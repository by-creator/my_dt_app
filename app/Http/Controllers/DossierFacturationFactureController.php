<?php

namespace App\Http\Controllers;

use App\Enums\StatutDossier;
use App\Mail\FactureDocumentsMail;
use App\Mail\FactureValidateMail;
use App\Mail\ProformaValidateMail;
use App\Models\DossierFacturation;
use App\Models\DossierFacturationFacture;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;


class DossierFacturationFactureController extends Controller
{
    public function facture()
    {
        $dossiers = DossierFacturation::orderBy('id', 'desc')->get();
        $users = User::all();
        return view('dossier_facturation.facture', compact('dossiers', 'users'));
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
            'facture.*' => 'nullable|mimes:pdf|max:2048',
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
    // Étape 4 : Sauvegarder la facture
    // -----------------------------
    private function saveFacture(DossierFacturation $dossier, array $filesData)
    {
        $facture = new DossierFacturationFacture($filesData);
        $facture->dossier_facturation_id = $dossier->id;
        $facture->save();

        return $facture;
    }

    // -----------------------------
    // Étape 5 : Mettre à jour le dossier
    // -----------------------------
    private function updateDossier(DossierFacturation $dossier, DossierFacturationFacture $facture)
    {
        $dossier->user_id = Auth::id();
        $dossier->statut = StatutDossier::FACTURE_VALIDE;

        // Mettre à jour time_elapsed
        $dossier->time_elapsed = $dossier->updated_at->greaterThan($facture->created_at)
            ? $facture->created_at->diffInSeconds($dossier->updated_at)
            : $dossier->updated_at->diffInSeconds($facture->created_at);



        $dossier->save();
    }

    // -----------------------------
    // Étape 6 : Envoyer le mail
    // -----------------------------
    private function sendMailToRattachement($rattachement, DossierFacturationFacture $facture, $documents)
    {
        $data = [
            'email'  => $rattachement->email, // ajouter cette ligne
            'prenom' => $rattachement->prenom,
            'nom'    => $rattachement->nom,
            'bl'     => $rattachement->bl,
            'date'   => $facture->created_at->format('d/m/Y H:i'),
            'documents' => $documents,
        ];

        // Liste des destinataires
        $destinataires = [
            'noreplysitedt@gmail.com'
        ];

        Mail::to($rattachement->email)
            ->cc($destinataires)
            ->send(new FactureDocumentsMail($data));
    }

    // -----------------------------
    // Étape 7 : Effectuer le post
    // -----------------------------

    public function sendDocuments(Request $request, $id)
    {
        Log::info("Début de l'envoi des documents pour le dossier ID : $id");

        $dossier = $this->getDossier($id);
        Log::info("Dossier récupéré", ['dossier_id' => $dossier->id]);

        if ($dossier->statut === StatutDossier::EN_ATTENTE_FACTURE) {

            $rattachement = $this->getRattachement($dossier);
            Log::info("Rattachement récupéré", [
                'rattachement_id' => $rattachement->id ?? null,
                'email' => $rattachement->email
            ]);

            $filesData = $this->handleUpload($request, ['facture']);
            Log::info("Fichiers uploadés", ['files' => $filesData['facture'] ?? []]);

            $facture = $this->saveFacture($dossier, $filesData);
            Log::info("Facture créée", ['facture_id' => $facture->id]);

            $this->updateDossier($dossier, $facture);
            Log::info("Dossier mis à jour", [
                'user_id' => $dossier->user_id,
                'statut' => $dossier->statut,
                'time_elapsed' => $dossier->time_elapsed
            ]);

            $this->sendMailToRattachement($rattachement, $facture, $filesData['facture']);
            Log::info("Mail envoyé au rattachement", ['email' => $rattachement->email]);

            Log::info("Fin de l'envoi des documents pour le dossier ID : $id");

            return back()->with('successFacture', 'Documents envoyés et mail transmis avec succès !');
        } else {
            return back()->with('infoFacture', 'La facture est déjà disponible');
        }
    }

    public function validate($id)
    {
        $dossier = DossierFacturation::findOrFail($id);

        if ($dossier->statut === StatutDossier::FACTURE_VALIDE) {

            $dossier->statut = StatutDossier::EN_ATTENTE_BAD;

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
            Mail::to($destinataires)->send(new FactureValidateMail($data));


            Log::info('Votre facture sera disponible dans 10 minutes');

            return redirect()->back()->with('successFacture', "Votre BAD sera disponible dans 10 minutes ");
        } else {
            return redirect()->back()->with('infoFacture', "Votre BAD est soit en cours de traitement ou soit déjà disponible");
        }
    }

}
