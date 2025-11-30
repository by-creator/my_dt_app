<?php

namespace App\Http\Controllers;

use App\Mail\ProformaDocumentsMail;
use App\Mail\ProformaGenerateMail;
use App\Models\DossierFacturation;
use App\Models\DossierFacturationProforma;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;


class DossierFacturationProformaController extends Controller
{
    public function proforma()
    {
        $dossiers = DossierFacturation::orderBy('id', 'desc')->get();
        $users = User::all();
        return view('dossier_facturation.proforma', compact('dossiers', 'users'));
    }

    public function proformaGenerate(Request $request, $id)
    {
        $request->validate([
            'documentDate' => 'required|date',
        ]);

        $dossier = DossierFacturation::findOrFail($id);

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


        Log::info('Demande de facture pro-forma envoyée');



        $dossier->date_proforma = $date;

        $dossier->statut = "EN ATTENTE PROFORMA";

        // Ici tu peux mettre à jour updated_at si nécessaire
        $dossier->updated_at = now(); // ou la date spécifique


        // Sauvegarde les changements
        $dossier->save();

        return redirect()->back()->with('success', "Votre facture sera disponible dans 10 minutes ");
    }

    public function sendDocuments(Request $request)
    {
        $fields = ['proforma'];

        $validated = $request->validate([
            'proforma.*' => 'nullable|mimes:pdf|max:2048',
            'dossier_id' => 'required|exists:dossier_facturations,id',
        ]);

        $dossier = DossierFacturation::findOrFail($request->dossier_id);
        $rattachement = $dossier->rattachement_bl;

        if (!$rattachement || !$rattachement->email) {
            return back()->with('error', 'Aucun rattachement BL trouvé pour ce dossier.');
        }

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

        $proforma = new DossierFacturationProforma($saveData);
        $proforma->dossier_facturation_id = $dossier->id;
        $proforma->save();

        // Mettre à jour time_elapsed
        $dossier->time_elapsed = Carbon::parse($proforma->created_at)
            ->diffInSeconds($dossier->updated_at);
        $dossier->save();

        // Envoyer le mail
        $data = [
            'prenom' => $rattachement->prenom,
            'nom'    => $rattachement->nom,
            'bl'     => $rattachement->bl,
            'date'   => $proforma->created_at->format('d/m/Y H:i'),
            'documents' => $saveData['proforma'],
        ];

        Mail::to($rattachement->email)
            ->cc('noreplysitedt@gmail.com')
            ->send(new ProformaDocumentsMail($data));

        return back()->with('success', 'Documents envoyés et mail transmis avec succès !');
    }
}
