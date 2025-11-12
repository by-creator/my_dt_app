<?php

namespace App\Http\Controllers;

use App\Mail\ValidationIesMail;
use App\Models\RattachementBl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class DematController extends Controller
{
    public function validation(Request $request)
    {
        $data = $request->validate([
            'prenom' => 'required|string|max:255',
            'nom' => 'required|string|max:255',
            'email' => 'required|email',
            'bl' => 'required|string',
            'compte' => 'required|string',
            'documents' => 'required',
        ]);

        $documents = [];     // Chemins des fichiers
        $fileNames = [];     // Noms originaux

        if ($request->hasFile('documents')) {
            foreach ($request->file('documents') as $file) {
                $documents[] = $file; // 🔹 on garde directement l'objet UploadedFile
                $fileNames[] = $file->getClientOriginalName();
            }
        }

        $destinataires = [

            //'sn004-proforma@dakar-terminal.com',
            //'sn004-facturation@dakar-terminal.com',
            'noreplysitedt@gmail.com'
        ];

        $nomComplet = $data['prenom'] . ' ' . $data['nom'];
        
        Mail::to($destinataires)->send(
            new ValidationIesMail(
                bl: strtoupper($data['bl']),
                compte: strtoupper($data['compte']),
                documents: $documents,   // fichiers bruts
                fileNames: $fileNames,   // noms d’origine
                expediteurEmail: $data['email'],
                expediteurNom: $nomComplet
            )
        );

        $data_create = $request->validate([
            'prenom' => 'required|string|max:255',
            'nom' => 'required|string|max:255',
            'email' => 'required|email',
            'bl' => 'required|string',
            'compte' => 'required|string',
        ]);

        $data_create['bl'] = strtoupper($data_create['bl']);
        $data_create['compte'] = strtoupper($data_create['compte']);

        RattachementBl::create($data_create);
        
    return redirect()
            ->route('demat.index')
            ->with('sendValidation', 'Un mail de demande de validation a bien été envoyé au service facturation qui vous fera un retour par mail une fois la validation effecuée.');
   
    }
}
