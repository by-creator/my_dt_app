<?php

namespace App\Http\Controllers;

use App\Enums\StatutDossier;
use App\Mail\ProformaValidateMail;
use App\Models\DossierFacturation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class DossierFacturationFactureController extends Controller
{
    public function facture()
    {
        $dossiers = DossierFacturation::orderBy('id', 'desc')->get();
        $users = User::all();
        return view('dossier_facturation.facture', compact('dossiers', 'users'));
    }

    public function validate($id)
    {
        $dossier = DossierFacturation::findOrFail($id);

        if ($dossier->statut === StatutDossier::PROFORMA_VALIDE) {

            $dossier->statut = StatutDossier::EN_ATTENTE_FACTURE;

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
