<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\{
    GenerateProformaRequest,
    SendProformaDocumentsRequest
};
use App\Services\Proforma\{
    ProformaDossierService,
    ProformaUploadService,
    ProformaMailerService,
    ProformaGeneratorService
};
use App\Models\{
    DossierFacturation,
    DossierFacturationProforma,
    User
};
use App\Enums\StatutDossier;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\FacadesLog;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class DossierFacturationProformaController extends Controller
{
    public function __construct(
        private ProformaDossierService $dossierService,
        private ProformaUploadService $uploadService,
        private ProformaMailerService $mailer,
        private ProformaGeneratorService $generator
    ) {}

    public function proforma()
    {
        // Récupérer les dossiers de facturation dans les statuts spécifiés
        $dossiers = DossierFacturation::whereIn(
            'statut',
            [
                StatutDossier::EN_ATTENTE_PROFORMA,
                StatutDossier::EN_ATTENTE_PROFORMA_COMPLEMENTAIRE,
            ]
        )
            ->orderBy('id', 'desc')
            ->get();

        // Récupérer tous les utilisateurs et l'utilisateur connecté
        $users = User::all();
        $user = Auth::user();

        // Renvoyer la vue avec les données nécessaires
        return view('dossier_facturation.proforma', compact('dossiers', 'users', 'user'));
    }

    public function list()
    {
        // Charger les dossiers et leurs proformas associés
        // En utilisant la méthode 'with' pour charger la relation 'proformas'
        $dossiers = DossierFacturation::with('proformas') // Assurez-vous que la relation 'proformas' existe
            ->orderBy('id', 'desc')
            ->get();

        // Récupérer l'utilisateur connecté
        $user = Auth::user();

        // Passer la collection de dossiers à la vue
        return view('dossier_facturation.list_proforma', compact('dossiers', 'user'));
    }



    public function generate(GenerateProformaRequest $request, $id)
    {
        $dossier = $this->dossierService->getDossier($id);

        if ($dossier->statut !== StatutDossier::VALIDE) {
            return back()->with('info', 'Votre facture proforma est déjà en cours ou disponible');
        }

        $date = Carbon::parse($request->documentDate);
        $rattachement = $this->dossierService->getRattachement($dossier);

        $this->generator->generate($dossier, $date);

        $this->mailer->sendGenerate([
            'date' => $date,
            'prenom' => $rattachement->prenom,
            'nom' => $rattachement->nom,
            'email' => $rattachement->email,
            'bl' => $rattachement->bl,
            'compte' => $rattachement->compte,
        ]);

        return back()->with('success', 'Votre facture proforma sera disponible dans 10 minutes');
    }


    public function sendDocuments(SendProformaDocumentsRequest $request, $id)
    {
        $dossier = $this->dossierService->getDossier($id);
        $rattachement = $this->dossierService->getRattachement($dossier);

        $files = $this->uploadService->upload($request, ['proforma']);

        if (empty($files['proforma'][0]['path'])) {
            return back()->with('error', 'Erreur lors de l’upload du fichier proforma.');
        }

        //$path = $files['proforma'][0]['path'];

        $proforma = DossierFacturationProforma::create([
            'dossier_facturation_id' => $dossier->id,
            'proforma' => $files, // JSON COMPLET
        ]);


        $proforma->proforma = $files;

        $proforma->save();

        $this->dossierService->updateDossier($dossier, $proforma);

        $documents = $files['proforma']; // tableau complet

        $this->mailer->sendDocuments($rattachement, $proforma, $documents);


        return back()->with('successProforma', 'Documents envoyés avec succès');
    }


    public function rejectDocuments(Request $request, $id)
    {
        Log::info('Rejet de la proforma', ['id' => $id]);

        // Récupérer le dossier de facturation
        $dossier = $this->dossierService->getDossier($id);

        // Vérifier que le dossier est dans un statut valide pour le rejet
        if (!in_array($dossier->statut, [StatutDossier::EN_ATTENTE_PROFORMA, StatutDossier::EN_ATTENTE_PROFORMA_COMPLEMENTAIRE])) {
            return back()->with('error', 'Le dossier ne peut pas être rejeté dans cet état.');
        }

        try {
            // Récupérer le motif de rejet depuis la requête
            $motif = $request->input('motif');

            // Si "Autre motif" est sélectionné, on prend la valeur du champ texte
            if ($motif === 'autre') {
                $motif = $request->input('autreMotif'); // Récupère le motif personnalisé
            }

            // Rejeter le dossier avec le motif
            $this->dossierService->reject($dossier, $motif, $request->input('autreMotif'));

            // Récupérer le rattachement BL du dossier pour l'email
            $rattachement = $dossier->rattachement_bl;

            // Envoi du mail avec le motif de rejet
            $this->mailer->sendReject($rattachement, $motif, $request->input('autreMotif'));  // Assurez-vous de bien envoyer 'autre_motif'

            // Retour avec un message de succès
            return back()->with('success', 'Proforma rejetée avec succès');
        } catch (\Throwable $e) {
            Log::error('Erreur rejet proforma', [
                'id' => $id,
                'message' => $e->getMessage(),
            ]);

            return back()->with('error', 'Une erreur est survenue lors du rejet de la proforma.');
        }
    }

    public function validate($id)
    {
        $dossier = $this->dossierService->getDossier($id);

        // 👉 logique métier déplacée dans le service
        $message = $this->dossierService->validate($dossier);

        // 👉 cas où on ne doit PAS envoyer de mail
        if ($message !== null) {
            return back()->with('info', $message);
        }

        // 👉 récupération du rattachement
        $rattachement = $this->dossierService->getRattachement($dossier);

        // 👉 envoi du mail via le mailer existant
        $this->mailer->sendValidate([
            'prenom' => $rattachement->prenom,
            'nom' => $rattachement->nom,
            'email' => $rattachement->email,
            'bl' => $rattachement->bl,
            'compte' => $rattachement->compte,
        ]);

        Log::info('[PROFORMA_VALIDATE]', [
            'dossier_id' => $dossier->id,
            'statut' => $dossier->statut,
        ]);

        return back()->with(
            'success',
            "Votre facture définitive sera disponible dans 10 minutes"
        );
    }


    public function delete($id)
    {
        $dossier = DossierFacturation::findOrFail($id);
        $proforma = DossierFacturationProforma::firstWhere('dossier_facturation_id', $dossier->id);

        if ($dossier->statut === StatutDossier::PROFORMA_VALIDE) {

            $proforma->delete();
            $dossier->statut = StatutDossier::VALIDE;
            $dossier->date_proforma = NULL;
        } elseif ($dossier->statut === StatutDossier::PROFORMA_COMPLEMENTAIRE_VALIDE) {

            $proforma->delete();
            $dossier->statut = StatutDossier::FACTURE_VALIDE;
            $dossier->date_proforma = NULL;
        } else {
            return redirect()->back()->with('info', "Votre facture proforma est soit en cours de traitement ou soit déjà disponible");
        }

        $dossier->save();

        Log::info('Facture proforma supprimée');


        return redirect()->back()->with('success', "Votre facture a bien été supprimée ");
    }

    public function relanceDocuments($id)
    {
        $dossier = $this->dossierService->getDossier($id);

        // 👉 Logique métier déplacée dans le service
        $message = $this->dossierService->relanceProforma($dossier);

        // 👉 Cas où la relance n’est pas autorisée
        if ($message !== null) {
            return back()->with('info', $message);
        }

        // 👉 Récupération du rattachement BL
        $rattachement = $this->dossierService->getRattachement($dossier);

        // 👉 Envoi du mail via le mailer
        $this->mailer->sendRelance([
            'prenom' => $rattachement->prenom,
            'nom' => $rattachement->nom,
            'email' => $rattachement->email,
            'bl' => $rattachement->bl,
            'compte' => $rattachement->compte,
        ]);

        Log::info('[PROFORMA_RELANCE]', [
            'dossier_id' => $dossier->id,
            'statut' => $dossier->statut,
        ]);

        return back()->with(
            'success',
            "Votre relance a été effectuée avec succès"
        );
    }
}
