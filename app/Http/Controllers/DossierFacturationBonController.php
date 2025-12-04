<?php

namespace App\Http\Controllers;

use App\Enums\StatutDossier;
use App\Mail\BonDocumentsMail;
use App\Models\DossierFacturation;
use App\Models\DossierFacturationBon;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class DossierFacturationBonController extends Controller
{
    public function bon()
    {
        $dossiers = DossierFacturation::whereIn(
            'statut',
            [
                StatutDossier::EN_ATTENTE_BAD,
                StatutDossier::BAD_VALIDE,
            ]
        )
            ->orderBy('id', 'desc')
            ->get();
        $users = User::all();
        return view('dossier_facturation.bon', compact('dossiers', 'users'));
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
            'bon.*' => 'nullable|mimes:pdf|max:2048',
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
    // Étape 4 : Sauvegarder le bon
    // -----------------------------
    private function saveBon(DossierFacturation $dossier, array $filesData)
    {
        $bon = new DossierFacturationBon($filesData);
        $bon->dossier_facturation_id = $dossier->id;
        $bon->save();

        return $bon;
    }

    // -----------------------------
    // Étape 5 : Mettre à jour le dossier
    // -----------------------------
    private function updateDossier(DossierFacturation $dossier, DossierFacturationBon $bon)
    {
        $dossier->user_id = Auth::id();
        $dossier->statut = StatutDossier::BAD_VALIDE;

       if ($dossier->date_en_attente_bon) {
        $seconds = 
            Carbon::parse($dossier->date_en_attente_bon)->diffInSeconds(now());

            $dossier->time_elapsed_bon = DossierFacturation::secondsToHms($seconds);
    }


        $dossier->save();
    }

    // -----------------------------
    // Étape 6 : Envoyer le mail
    // -----------------------------
    private function sendMailToRattachement($rattachement, DossierFacturationBon $bon, $documents)
    {
        $data = [
            'email'  => $rattachement->email, // ajouter cette ligne
            'prenom' => $rattachement->prenom,
            'nom'    => $rattachement->nom,
            'bl'     => $rattachement->bl,
            'date'   => $bon->created_at->format('d/m/Y H:i'),
            'documents' => $documents,
        ];

        // Liste des destinataires
        $destinataires = [
            'noreplysitedt@gmail.com'
        ];

        Mail::to($rattachement->email)
            ->cc($destinataires)
            ->send(new BonDocumentsMail($data));
    }

    // -----------------------------
    // Étape 7 : Effectuer le post
    // -----------------------------

    public function sendDocuments(Request $request, $id)
    {
        Log::info("Début de l'envoi des documents pour le dossier ID : $id");

        $dossier = $this->getDossier($id);
        Log::info("Dossier récupéré", ['dossier_id' => $dossier->id]);

        if ($dossier->statut === StatutDossier::EN_ATTENTE_BAD) {

            $rattachement = $this->getRattachement($dossier);
            Log::info("Rattachement récupéré", [
                'rattachement_id' => $rattachement->id ?? null,
                'email' => $rattachement->email
            ]);

            $filesData = $this->handleUpload($request, ['bon']);
            Log::info("Fichiers uploadés", ['files' => $filesData['bon'] ?? []]);

            $bon = $this->saveBon($dossier, $filesData);
            Log::info("Bon créée", ['bon_id' => $bon->id]);

            $this->updateDossier($dossier, $bon);
            Log::info("Dossier mis à jour", [
                'user_id' => $dossier->user_id,
                'statut' => $dossier->statut,
                'time_elapsed' => $dossier->time_elapsed
            ]);

            $this->sendMailToRattachement($rattachement, $bon, $filesData['bon']);
            Log::info("Mail envoyé au rattachement", ['email' => $rattachement->email]);

            Log::info("Fin de l'envoi des documents pour le dossier ID : $id");

            return back()->with('successBon', 'Documents envoyés et mail transmis avec succès !');
        } else {
            return back()->with('infoBon', 'Le bon est déjà disponible');
        }
    }

}