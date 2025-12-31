<?php

namespace App\Http\Controllers;

use App\Enums\StatutDossier;
use App\Mail\RattachementBlInvalideMail;
use App\Mail\RattachementBlValideMail;
use App\Models\RattachementBl;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;


class RattachementController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $rattachement_validations = RattachementBl::whereIn(
            'statut',
            [
                StatutDossier::EN_ATTENTE_VALIDATION,
            ]
        )
            ->orderBy('id', 'desc')->get();
        $rattachements = RattachementBl::orderBy('id', 'desc')->get();
        $users = User::all();
        return view('rattachement_bl.index', compact('rattachements', 'rattachement_validations', 'users', 'user'));
    }

    public function list()
    {
        $rattachements = RattachementBl::orderBy('id', 'desc')->get();
        $users = User::all();
        $user = Auth::user();

        return view('rattachement_bl.list', compact('rattachements', 'rattachements', 'users','user'));
    }

    public function create($id)
    {
        Log::info("Début création du rattachement", ['id' => $id]);

        $rattachement = RattachementBl::findOrFail($id);

        // Ajout d'un log pour vérifier le statut du rattachement
        Log::info("Statut actuel du rattachement", [
            'statut_bdd' => $rattachement->statut,
            'statut_constante' => StatutDossier::EN_ATTENTE_VALIDATION,
            'equal' => $rattachement->statut == StatutDossier::EN_ATTENTE_VALIDATION,
            'identical' => $rattachement->statut === StatutDossier::EN_ATTENTE_VALIDATION,
        ]);

        // Comparaison avec la constante
        if ($rattachement->statut === StatutDossier::EN_ATTENTE_VALIDATION) {
            Log::info("Rattachement en attente de validation, traitement en cours", [
                'id' => $rattachement->id,
                'email' => $rattachement->email,
                'statut' => $rattachement->statut
            ]);

            try {
                // Mise à jour du rattachement
                $rattachement->user_id = Auth::id();
                $rattachement->statut = StatutDossier::VALIDE;  // Ici on met à jour le statut à "VALIDE"
                $rattachement->time_elapsed = $rattachement->created_at->diffForHumans(now(), true);

                Log::info("Rattachement mis à jour", [
                    'user_id' => $rattachement->user_id,
                    'statut' => $rattachement->statut,
                    'time_elapsed' => $rattachement->time_elapsed
                ]);

                // Destinataires pour l'email
                $destinataires = [
                    'sn004-proforma@dakar-terminal.com',
                    'sn004-facturation@dakar-terminal.com',
                    //'noreplysitedt@gmail.com'
                ];

                // Envoi de l'email de validation
                Log::info("Envoi email de validation", [
                    'destinataires' => $destinataires,
                    'rattachement_email' => $rattachement->email,
                    'bl' => $rattachement->bl,
                    'nom' => $rattachement->nom,
                    'prenom' => $rattachement->prenom
                ]);

                Mail::to($rattachement->email)
                    ->cc($destinataires)
                    ->send(new RattachementBlValideMail($rattachement->bl, $rattachement->nom, $rattachement->prenom));

                // Sauvegarde du rattachement
                $rattachement->save();
                Log::info("Rattachement validé et sauvegardé", ['id' => $rattachement->id]);

                // Création du dossier de facturation
                $rattachement->dossierFacturation()->create([
                    'statut' => $rattachement->statut
                ]);
                Log::info("Dossier de facturation créé pour le rattachement", ['id' => $rattachement->id]);

                return redirect()->back()->with('valide', 'Dossier validé avec succès.');
            } catch (\Exception $e) {
                Log::error("Erreur lors de la validation du rattachement", [
                    'id' => $rattachement->id,
                    'message' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
                return redirect()->back()->with('error', 'Une erreur est survenue lors de la validation.');
            }
        } else {
            Log::warning("Tentative de validation d'un dossier déjà traité", [
                'id' => $rattachement->id,
                'statut' => $rattachement->statut
            ]);
            return redirect()->back()->with('error', 'Dossier déjà traité.');
        }
    }

    public function update($id, Request $request)
    {
        Log::info("Début update rattachement", ['id' => $id]);

        $rattachement = RattachementBl::findOrFail($id);

        Log::info("Comparaison debug", [
            'statut_bdd' => $rattachement->statut,
            'statut_constante' => StatutDossier::EN_ATTENTE_VALIDATION,
            'equal' => $rattachement->statut == StatutDossier::EN_ATTENTE_VALIDATION,
            'identical' => $rattachement->statut === StatutDossier::EN_ATTENTE_VALIDATION,
        ]);

        if ($rattachement->statut === StatutDossier::EN_ATTENTE_VALIDATION) {

            Log::info("Rattachement en attente, mise à jour en cours", [
                'id' => $rattachement->id,
                'statut' => $rattachement->statut,
                'email' => $rattachement->email
            ]);


            try {
                $rattachement->user_id = Auth::id();
                $rattachement->statut = StatutDossier::REJETE;
                $rattachement->time_elapsed = $rattachement->created_at->diffForHumans(now(), true);

                $destinataires = [
                    'sn004-proforma@dakar-terminal.com',
                    'sn004-facturation@dakar-terminal.com',
                    //'noreplysitedt@gmail.com'
                ];

                $motif = $request->motif;

                Log::info("Envoi email rejet", [
                    'destinataires' => $destinataires,
                    'motif' => $motif
                ]);

                Mail::to($rattachement->email)->cc($destinataires)->send(
                    new RattachementBlInvalideMail(
                        $rattachement->bl,
                        $rattachement->nom,
                        $rattachement->prenom,
                        $motif
                    )
                );

                $rattachement->save();

                Log::info("Rattachement rejeté avec succès", ['id' => $rattachement->id]);

                return redirect()->back()->with('invalide', 'Dossier rejeté avec succès.');
            } catch (\Exception $e) {

                Log::error("Erreur lors du rejet du rattachement", [
                    'id' => $rattachement->id,
                    'message' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);

                return redirect()->back()->with('error', 'Une erreur est survenue lors du rejet.');
            }
        } else {
            Log::warning("Tentative de rejet d’un dossier déjà traité", [
                'id' => $rattachement->id,
                'statut' => $rattachement->statut
            ]);

            return redirect()->back()->with('error', 'Dossier déjà traité.');
        }
    }
}
