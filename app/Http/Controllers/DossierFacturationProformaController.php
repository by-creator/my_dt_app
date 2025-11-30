<?php

namespace App\Http\Controllers;

use App\Mail\ProformaGenerateMail;
use App\Models\DossierFacturation;
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

}
