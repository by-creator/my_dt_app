<?php

namespace App\Http\Controllers;

use App\Enums\StatutDossier;
use App\Mail\ProformaDocumentsMail;
use App\Mail\ProformaGenerateMail;
use App\Mail\ProformaValidateMail;
use App\Models\DossierFacturation;
use App\Models\DossierFacturationProforma;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;



class DossierFacturationProformaController extends Controller
{
    public function proforma()
    {
        $dossiers = DossierFacturation::orderBy('id', 'desc')->get();
        $users = User::all();
        return view('dossier_facturation.proforma', compact('dossiers', 'users'));
    }

    public function generate(Request $request, $id)
    {
        $request->validate([
            'documentDate' => 'required|date',
        ]);

        $dossier = DossierFacturation::findOrFail($id);

        if ($dossier->statut === StatutDossier::VALIDE) {
            // Exemple : générer le document avec la date choisie
            $date = Carbon::parse($request->input('documentDate'));


            // On récupère le rattachement BL
            $rattachement = $dossier->rattachement_bl;

            // On prépare les données à envoyer dans le mail
            $data = [
                'date' => $date,
                'prenom'  => $rattachement->prenom,
                'nom'     => $rattachement->nom,
                'email'   => $rattachement->email,
                'bl'      => $rattachement->bl,
                'compte'  => $rattachement->compte,
            ];

            // Liste des destinataires
            $destinataires = [
                'noreplysitedt@gmail.com'
            ];

            // Envoi du mail
            Mail::to($destinataires)->send(new ProformaGenerateMail($data));


            Log::info('Demande de facture proforma envoyée');

            $dossier->date_proforma = $date;

            $dossier->statut = StatutDossier::EN_ATTENTE_PROFORMA;

            // Ici tu peux mettre à jour updated_at si nécessaire
            $dossier->updated_at = now(); // ou la date spécifique


            // Sauvegarde les changements
            $dossier->save();

            return redirect()->back()->with('successProforma', "Votre facture sera disponible dans 10 minutes ");
        } else {
            return redirect()->back()->with('infoProforma', "Votre proforma est soit en cours de traitement ou soit déjà disponible");
        }
    }


    // -----------------------------
    // Étape 1 : Récupérer le dossier
    // -----------------------------
    private function getDossier($id)
    {
        return DossierFacturation::findOrFail($id);
    }

    // -----------------------------
    // Étape 2 : Récupérer le rattachement
    // -----------------------------
    private function getRattachement(DossierFacturation $dossier)
    {
        $rattachement = $dossier->rattachement_bl;

        if (!$rattachement || !$rattachement->email) {
            abort(400, 'Aucun rattachement BL trouvé pour ce dossier.');
        }

        return $rattachement;
    }

    // -----------------------------
    // Étape 3 : Gestion de l’upload
    // -----------------------------
    private function handleUpload(Request $request, array $fields)
    {
        $request->validate([
            'proforma.*' => 'nullable|mimes:pdf|max:2048',
        ]);

        $saveData = [];

        foreach ($fields as $field) {
            $saveData[$field] = [];

            if ($request->hasFile($field)) {
                foreach ($request->file($field) as $file) {
                    $path = $file->store("documents/$field", 'b2');

                    if ($path) {
                        $saveData[$field][] = [
                            'original' => $file->getClientOriginalName(),
                            'path' => $path,
                        ];
                    }
                }
            }
        }

        return $saveData;
    }

    // -----------------------------
    // Étape 4 : Sauvegarder la proforma
    // -----------------------------
    private function saveProforma(DossierFacturation $dossier, array $filesData)
    {
        $proforma = new DossierFacturationProforma($filesData);
        $proforma->dossier_facturation_id = $dossier->id;
        $proforma->save();

        return $proforma;
    }

    // -----------------------------
    // Étape 5 : Mettre à jour le dossier
    // -----------------------------
    private function updateDossier(DossierFacturation $dossier, DossierFacturationProforma $proforma)
    {
        $dossier->user_id = Auth::id();
        $dossier->statut = StatutDossier::PROFORMA_VALIDE;

        // Mettre à jour time_elapsed
        $dossier->time_elapsed = $dossier->updated_at->greaterThan($proforma->created_at)
            ? $proforma->created_at->diffInSeconds($dossier->updated_at)
            : $dossier->updated_at->diffInSeconds($proforma->created_at);



        $dossier->save();
    }

    // -----------------------------
    // Étape 6 : Envoyer le mail
    // -----------------------------
    private function sendMailToRattachement($rattachement, DossierFacturationProforma $proforma, $documents)
    {
        $data = [
            'email'  => $rattachement->email, // ajouter cette ligne
            'prenom' => $rattachement->prenom,
            'nom'    => $rattachement->nom,
            'bl'     => $rattachement->bl,
            'date'   => $proforma->created_at->format('d/m/Y H:i'),
            'documents' => $documents,
        ];

        // Liste des destinataires
        $destinataires = [
            'noreplysitedt@gmail.com'
        ];

        Mail::to($rattachement->email)
            ->cc($destinataires)
            ->send(new ProformaDocumentsMail($data));
    }


    // -----------------------------
    // Étape 7 : Effectuer le post
    // -----------------------------

    public function sendDocuments(Request $request, $id)
    {
        Log::info("Début de l'envoi des documents pour le dossier ID : $id");

        $dossier = $this->getDossier($id);
        Log::info("Dossier récupéré", ['dossier_id' => $dossier->id]);

        if ($dossier->statut === StatutDossier::EN_ATTENTE_PROFORMA && $dossier->date_proforma != NULL) {

            $rattachement = $this->getRattachement($dossier);
            Log::info("Rattachement récupéré", [
                'rattachement_id' => $rattachement->id ?? null,
                'email' => $rattachement->email
            ]);

            $filesData = $this->handleUpload($request, ['proforma']);
            Log::info("Fichiers uploadés", ['files' => $filesData['proforma'] ?? []]);

            $proforma = $this->saveProforma($dossier, $filesData);
            Log::info("Proforma créée", ['proforma_id' => $proforma->id]);

            $this->updateDossier($dossier, $proforma);
            Log::info("Dossier mis à jour", [
                'user_id' => $dossier->user_id,
                'statut' => $dossier->statut,
                'time_elapsed' => $dossier->time_elapsed
            ]);

            $this->sendMailToRattachement($rattachement, $proforma, $filesData['proforma']);
            Log::info("Mail envoyé au rattachement", ['email' => $rattachement->email]);

            Log::info("Fin de l'envoi des documents pour le dossier ID : $id");

            return back()->with('successProforma', 'Documents envoyés et mail transmis avec succès !');
        } else {
            return back()->with('infoProforma', 'Le client doit soit au préalable saisir une date ou soit la proforma est déjà disponible');
        }
    }

    public function validate($id)
    {
        $dossier = DossierFacturation::findOrFail($id);

        if ($dossier->statut === StatutDossier::PROFORMA_VALIDE) {

            $dossier->statut = StatutDossier::EN_ATTENTE_FACTURE;

            $dossier->save();

            // On récupère le rattachement BL
            $rattachement = $dossier->rattachement_bl;

            // On prépare les données à envoyer dans le mail
            $data = [
                'prenom'  => $rattachement->prenom,
                'nom'     => $rattachement->nom,
                'email'   => $rattachement->email,
                'bl'      => $rattachement->bl,
                'compte'  => $rattachement->compte,
            ];


            // Liste des destinataires
            $destinataires = [
                'noreplysitedt@gmail.com'
            ];

            // Envoi du mail
            Mail::to($destinataires)->send(new ProformaValidateMail($data));


            Log::info('Votre facture sera disponible dans 10 minutes');

            return redirect()->back()->with('successFacture', "Votre facture sera disponible dans 10 minutes ");
        } else {
            return redirect()->back()->with('infoFacture', "Votre facture est soit en cours de traitement ou soit déjà disponible");
        }
    }
}
