<?php

namespace App\Http\Controllers;

use App\Mail\ValidationDematMail;
use App\Mail\ValidationIesMail;
use App\Models\RattachementBl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;


class DematController extends Controller
{
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
                'documents' => 'required|max:20480',
            ]);

            // Récupération des fichiers
            $files = $request->file('documents');
            if ($files instanceof \Illuminate\Http\UploadedFile) {
                $files = [$files]; // Transforme en tableau si un seul fichier
            }

            // Destinataires
            $destinataires = [
                //'sn004-proforma@dakar-terminal.com',
                //'sn004-facturation@dakar-terminal.com',
                'noreplysitedt@gmail.com',
            ];

            // Envoi du mail
            Mail::to($destinataires)
                ->send(new ValidationDematMail($data, $files));

            Log::info('Demande de validation envoyée', ['email' => $data['email']]);

            return redirect()
                ->route('demat.index')
                ->with('sendValidation', 'Votre demande a été envoyée avec succès.');
        } catch (\Exception $e) {
            Log::error('Erreur mail validation : ' . $e->getMessage(), [
                'data' => $request->all()
            ]);

            return redirect()
                ->route('demat.index')
                ->with('error', 'Une erreur est survenue lors de l’envoi.');
        }
    }
}
