<?php

namespace App\Http\Controllers;

use App\Mail\ProformaGenerateMail;
use App\Models\DossierFacturation;
use App\Models\RattachementBl;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class DossierFacturationController extends Controller
{

    public function index()
    {
        return view('dossier_facturation.form');
    }

    public function show(DossierFacturation $dossier)
    {
        return view('dossier_facturation.show', compact('dossier'));
    }

    public function list()
    {
        $dossiers = DossierFacturation::orderBy('created_at', 'desc')->get();
        return view('dossier_facturation.list', compact('dossiers'));
    }

    public function store(Request $request)
    {
        $fields = ['proforma', 'facture', 'bon'];

        $validated = $request->validate([
            'proforma.*' => 'nullable|mimes:pdf|max:2048',
            'facture.*' => 'nullable|mimes:pdf|max:2048',
            'bon.*' => 'nullable|mimes:pdf|max:2048',
            'date_proforma' => 'nullable|date',
        ]);

        $saveData = [
            'date_proforma' => $request->date_proforma,
        ];

        foreach ($fields as $field) {
            $saveData[$field] = [];

            if ($request->hasFile($field)) {
                foreach ($request->file($field) as $file) {
                    $path = $file->store("documents/$field", 'b2'); // B2 disk

                    if ($path) {
                        $saveData[$field][] = [
                            'original' => $file->getClientOriginalName(),
                            'path' => $path,
                        ];
                    }
                }
            }
        }

        DossierFacturation::create($saveData);

        return back()->with('success', 'Documents enregistrés avec succès !');
    }

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
            $rattachement->email,
            'noreplysitedt@gmail.com'
        ]; 

        // Envoi du mail
        Mail::to($destinataires)->send(new ProformaGenerateMail($data));


        Log::info('Demande de facture pro-forma envoyée', ['email' => $dossier['email']]);

        // Exemple : générer le document avec la date choisie
        $date = $request->input('documentDate');

        $dossier->date_proforma = $date;

        $dossier->statut = "EN ATTENTE PROFORMA";

        // Ici tu peux mettre à jour updated_at si nécessaire
        $dossier->updated_at = now(); // ou la date spécifique
        // On veut que created_at reçoive la même valeur
        $dossier->created_at = $dossier->updated_at;

        // Sauvegarde les changements
        $dossier->save();

        return redirect()->back()->with('success', "Votre facture sera disponible dans 10 minutes ");
    }


    public function facture()
    {
        return view('dossier_facturation.facture');
    }

    public function bon()
    {

        return view('dossier_facturation.bon');
    }
}
