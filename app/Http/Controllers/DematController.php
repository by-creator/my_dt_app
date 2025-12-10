<?php

namespace App\Http\Controllers;

use App\Mail\ValidationDematMail;
use App\Models\RattachementBl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;



class DematController extends Controller
{

    public function index()
    {
        return redirect()->route('login');
    }

    public function validation(Request $request)
    {

        try {
            // Validation des champs
            $data = $request->validate([
                'prenom' => 'required|string|max:255',
                'nom' => 'required|string|max:255',
                'email' => 'required|email',
                'bl' => 'required|string',
                'compte' => 'required|string',
                'documents.*' => 'file|max:20480', // 20480 Ko = 20 Mo

            ]);

            // Vérifier si le BL existe déjà
            $blExiste = RattachementBl::where('bl', $data['bl'])->exists();

            if ($blExiste) {
                return redirect()
                    ->back()
                    ->with('info', 'Ce BL est en cours de validation. Merci de patienter le mail de réponse de la facturation');
            }

            // Récupération des fichiers
            $files = $request->file('documents');
            if ($files instanceof \Illuminate\Http\UploadedFile) {
                $files = [$files]; // Transforme en tableau si un seul fichier
            }

            // Destinataires
            $destinataires = [
                'sn004-proforma@dakar-terminal.com',
                'sn004-facturation@dakar-terminal.com',
                //'noreplysitedt@gmail.com',
            ];

            // Envoi du mail
            Mail::to($destinataires)
                ->send(new ValidationDematMail($data, $files));

            Log::info('Demande de validation envoyée', ['email' => $data['email']]);

            $data_create = $request->validate([
                'prenom' => 'required|string|max:255',
                'nom' => 'required|string|max:255',
                'email' => 'required|email',
                'bl' => 'required|string',
                'compte' => 'required|string',

            ]);

            RattachementBl::create($data_create);

            return redirect()->back()
                ->with('success', 'Votre dossier sera disponible dans 10 minutes.');
        } catch (\Exception $e) {
            Log::error('Erreur mail validation : ' . $e->getMessage(), [
                'data' => $request->all()
            ]);

            return redirect()->back()
                ->with('error', 'Une erreur est survenue lors de l’envoi.');
        }
    }
}
