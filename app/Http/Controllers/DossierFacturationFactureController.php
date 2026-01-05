<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use App\Http\Requests\{
    FactureComplementRequest,
    SendFactureDocumentsRequest
};
use App\Services\Facture\{
    FactureDossierService,
    FactureUploadService,
    FactureWorkflowService,
    FactureMailerService
};
use App\Models\{
    DossierFacturation,
    DossierFacturationFacture,
    User
};
use App\Enums\StatutDossier;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class DossierFacturationFactureController extends Controller
{
    public function __construct(
        private FactureDossierService $dossierService,
        private FactureUploadService $uploadService,
        private FactureWorkflowService $workflow,
        private FactureMailerService $mailer
    ) {}

    public function facture()
    {
        return view('dossier_facturation.facture', [
            'dossiers' => DossierFacturation::whereIn(
                'statut',
                [
                    StatutDossier::EN_ATTENTE_FACTURE,
                    StatutDossier::EN_ATTENTE_FACTURE_COMPLEMENTAIRE
                ]
            )->latest()->get(),
            'users' => User::all(),
            'user' => Auth::user()
        ]);
    }

    public function list()
    {
        return view('dossier_facturation.list_facture', [
            'dossiers' => DossierFacturation::with('factures')->latest()->get(),
            'user' => Auth::user()
        ]);
    }

    public function complement(FactureComplementRequest $request, $id)
    {
        $dossier = $this->dossierService->getDossier($id);
        $rattachement = $this->dossierService->getRattachement($dossier);

        if (!in_array($dossier->statut, [
            StatutDossier::FACTURE_VALIDE,
            StatutDossier::BAD_VALIDE,
            StatutDossier::EN_ATTENTE_BAD,
            StatutDossier::FACTURE_COMPLEMENTAIRE_VALIDE
        ])) {
            return back()->with('info', 'Votre dossier ne contient pas encore de facture à prolonger');
        }

        $date = Carbon::parse($request->documentDate);

        $this->mailer->sendComplement([
            'date' => $date,
            'prenom' => $rattachement->prenom,
            'nom' => $rattachement->nom,
            'email' => $rattachement->email,
            'bl' => $rattachement->bl,
            'compte' => $rattachement->compte,
        ]);

        $dossier->update([
            'date_proforma' => $date,
            'statut' => StatutDossier::EN_ATTENTE_PROFORMA_COMPLEMENTAIRE,
            'date_en_attente_proforma' => now()
        ]);

        return back()->with('success', 'Votre proforma complémentaire sera disponible dans 10 minutes');
    }

    public function sendDocuments(SendFactureDocumentsRequest $request, $id)
    {
        $dossier = $this->dossierService->getDossier($id);
        $rattachement = $this->dossierService->getRattachement($dossier);

        $files = $this->uploadService->upload($request, ['facture']);

        if (empty($files['facture'][0]['path'])) {
            return back()->with('error', 'Erreur lors de l’upload de la facture.');
        }

        // 🔑 IDENTIQUE PROFORMA
        $facture = DossierFacturationFacture::create([
            'dossier_facturation_id' => $dossier->id,
            'facture' => $files, // JSON COMPLET
        ]);


        $facture->dossier_facturation_id = $dossier->id;
        $facture->facture = $files;
        $facture->save();

        // Workflow
        if ($dossier->statut === StatutDossier::EN_ATTENTE_FACTURE) {
            $this->workflow->validate($dossier, $facture);
        } elseif ($dossier->statut === StatutDossier::EN_ATTENTE_FACTURE_COMPLEMENTAIRE) {
            $this->workflow->validateComplement($dossier, $facture);
        }

        // Mail
        $this->mailer->sendDocuments(
            $rattachement,
            $facture,
            $files['facture']
        );

        return back()->with('successFacture', 'Facture envoyée avec succès');
    }



    public function validate($id)
    {
        $dossier = DossierFacturation::findOrFail($id);

        if (!in_array($dossier->statut, [
            StatutDossier::FACTURE_VALIDE,
            StatutDossier::FACTURE_COMPLEMENTAIRE_VALIDE
        ])) {
            return back()->with('info', 'Le BAD est en cours de traitement ou déjà disponible');
        }

        $dossier->update([
            'statut' => StatutDossier::EN_ATTENTE_BAD,
            'date_en_attente_bon' => now()
        ]);

        $rattachement = $dossier->rattachement_bl;

        $this->mailer->sendValidate([
            'prenom' => $rattachement->prenom,
            'nom' => $rattachement->nom,
            'email' => $rattachement->email,
            'bl' => $rattachement->bl,
            'compte' => $rattachement->compte,
        ]);

        return back()->with('success', 'Votre BAD sera disponible dans 10 minutes');
    }

    public function rejectDocuments(Request $request, $id)
    {
        Log::info('[FACTURE_REJECT]', ['id' => $id]);

        $dossier = $this->dossierService->getDossier($id);

        if (!in_array($dossier->statut, [
            StatutDossier::EN_ATTENTE_FACTURE,
            StatutDossier::EN_ATTENTE_FACTURE_COMPLEMENTAIRE
        ])) {
            return back()->with('error', 'La facture ne peut pas être rejetée dans cet état.');
        }

        $motif = $request->input('motif');

        if ($motif === 'autre') {
            $motif = $request->input('autre_motif');
        }

        // Sécurité ultime
        if (!$motif) {
            return back()->with('error', 'Le motif de rejet est obligatoire.');
        }


        // 👉 service métier
        $this->dossierService->rejectFacture($dossier);

        // 👉 mail
        $rattachement = $dossier->rattachement_bl;
        $this->mailer->sendReject($rattachement, $motif);

        return back()->with('success', 'Facture rejetée avec succès');
    }


    public function relanceDocuments($id)
    {
        $dossier = DossierFacturation::findOrFail($id);

        if (!in_array($dossier->statut, [
            StatutDossier::EN_ATTENTE_FACTURE,
            StatutDossier::EN_ATTENTE_FACTURE_COMPLEMENTAIRE
        ])) {
            return back()->with('info', 'Votre facture définitive est déjà disponible');
        }

        if ($dossier->relance_facture) {
            return back()->with(
                'info',
                'Vous avez déjà effectué une relance, votre facture est en cours de traitement'
            );
        }

        $dossier->update(['relance_facture' => true]);

        $rattachement = $dossier->rattachement_bl;

        $this->mailer->sendRelance([
            'prenom' => $rattachement->prenom,
            'nom' => $rattachement->nom,
            'email' => $rattachement->email,
            'bl' => $rattachement->bl,
            'compte' => $rattachement->compte,
        ]);

        return back()->with('success', 'Votre relance a été effectuée avec succès');
    }
}
