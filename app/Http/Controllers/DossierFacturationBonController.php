<?php

namespace App\Http\Controllers;

use App\Http\Requests\SendBonDocumentsRequest;
use App\Services\Bon\{
    BonDossierService,
    BonUploadService,
    BonWorkflowService,
    BonMailerService
};
use App\Models\{
    DossierFacturation,
    DossierFacturationBon,
    User
};
use App\Enums\StatutDossier;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class DossierFacturationBonController extends Controller
{
    public function __construct(
        private BonDossierService $dossierService,
        private BonUploadService $uploadService,
        private BonWorkflowService $workflow,
        private BonMailerService $mailer
    ) {}

    public function bon()
    {
        return view('dossier_facturation.bon', [
            'dossiers' => DossierFacturation::where(
                'statut',
                StatutDossier::EN_ATTENTE_BAD
            )->latest()->get(),
            'users' => User::all(),
            'user' => Auth::user()
        ]);
    }

    public function list()
    {
        return view('dossier_facturation.list_bon', [
            'dossiers' => DossierFacturation::with('bons')->latest()->get(),
            'user' => Auth::user()
        ]);
    }

    public function sendDocuments(SendBonDocumentsRequest $request, $id)
    {
        $dossier = $this->dossierService->getDossier($id);

        if ($dossier->statut !== StatutDossier::EN_ATTENTE_BAD) {
            return back()->with('infoBon', 'Le bon est déjà disponible.');
        }

        $rattachement = $this->dossierService->getRattachement($dossier);

        $files = $this->uploadService->upload($request, ['bon']);

        if (empty($files['bon'][0]['path'])) {
            return back()->with('errorBon', 'Erreur lors de l’upload du bon.');
        }

        $bon = DossierFacturationBon::create([
            'dossier_facturation_id' => $dossier->id,
            'bon' => $files, // JSON COMPLET
        ]);



        $bon->bon = $files;
        $bon->save();

        $this->workflow->validate($dossier, $bon);

        $this->mailer->sendDocuments(
            $rattachement,
            $bon,
            $files['bon']
        );

        return back()->with('successBon', 'Documents envoyés avec succès');
    }



    public function rejectDocuments(Request $request, $id)
    {
        Log::info('[BON_REJECT]', ['id' => $id]);

        $dossier = $this->dossierService->getDossier($id);

        if ($dossier->statut !== StatutDossier::EN_ATTENTE_BAD) {
            return back()->with('error', 'Le bon ne peut pas être rejeté dans cet état.');
        }

        $motif = $request->input('motif');

        if ($motif === 'autre') {
            $motif = $request->input('autre_motif');
        }

        // Sécurité
        if (!$motif) {
            return back()->with('error', 'Le motif de rejet est obligatoire.');
        }

        // 👉 Service métier
        $this->dossierService->rejectBon($dossier);

        // 👉 Mail
        $rattachement = $dossier->rattachement_bl;
        $this->mailer->sendReject($rattachement, $motif);

        return back()->with('success', 'Bon rejeté avec succès');
    }


    public function relanceDocuments($id)
    {
        $dossier = DossierFacturation::findOrFail($id);

        if ($dossier->statut !== StatutDossier::EN_ATTENTE_BAD) {
            return back()->with('info', 'Votre BAD est déjà disponible');
        }

        if ($dossier->relance_bad) {
            return back()->with(
                'info',
                'Vous avez déjà effectué une relance, votre BAD est en cours de traitement'
            );
        }

        $dossier->update(['relance_bad' => true]);

        $rattachement = $dossier->rattachement_bl;

        $this->mailer->sendRelance([
            'prenom' => $rattachement->prenom,
            'nom' => $rattachement->nom,
            'email' => $rattachement->email,
            'bl' => $rattachement->bl,
            'compte' => $rattachement->compte,
        ]);

        return back()->with('success', 'Votre relance a été effectuée avec succès');
    }
}
