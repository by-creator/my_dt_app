<?php

namespace App\Http\Controllers;

use App\Models\{
    RattachementBl,
    User
};
use App\Enums\StatutDossier;
use App\Services\Rattachement\{
    RattachementService,
    RattachementWorkflowService,
    RattachementMailerService
};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class RattachementController extends Controller
{
    public function __construct(
        private RattachementService $service,
        private RattachementWorkflowService $workflow,
        private RattachementMailerService $mailer
    ) {}

    public function index()
    {
        $user = Auth::user();

        return view('rattachement_bl.index', [
            'rattachements' => RattachementBl::latest()->get(),
            'rattachement_validations' => RattachementBl::where(
                'statut',
                StatutDossier::EN_ATTENTE_VALIDATION
            )->latest()->get(),
            'users' => User::all(),
            'user' => $user
        ]);
    }

    public function list()
    {
        return view('rattachement_bl.list', [
            'rattachements' => RattachementBl::latest()->get(),
            'users' => User::all(),
            'user' => Auth::user()
        ]);
    }

    public function create($id)
    {
        Log::info('Validation rattachement', ['id' => $id]);

        $rattachement = $this->service->getOrFail($id);
        $this->service->ensurePending($rattachement);

        try {
            $this->workflow->validate($rattachement);
            $this->mailer->sendValidation($rattachement);

            return back()->with('valide', 'Dossier validé avec succès.');
        } catch (\Throwable $e) {
            Log::error('Erreur validation rattachement', [
                'id' => $id,
                'message' => $e->getMessage(),
            ]);

            return back()->with('error', 'Une erreur est survenue lors de la validation.');
        }
    }

    public function update($id, Request $request)
    {
        Log::info('Rejet rattachement', ['id' => $id]);

        // Récupérer le rattachement
        $rattachement = $this->service->getOrFail($id);
        $this->service->ensurePending($rattachement);

        // Vérifier si l'utilisateur a sélectionné "autre" comme motif
        $motif = $request->motif;

        if ($motif === 'autre' && !empty($request->autreMotif)) {
            // Si "Autre motif" est sélectionné, utiliser la valeur personnalisée
            $motif = $request->autreMotif;
        }

        try {
            // Traiter le rejet avec le motif (qu'il soit pré-défini ou personnalisé)
            $this->workflow->reject($rattachement);
            $this->mailer->sendRejection($rattachement, $motif);

            return back()->with('invalide', 'Dossier rejeté avec succès.');
        } catch (\Throwable $e) {
            Log::error('Erreur rejet rattachement', [
                'id' => $id,
                'message' => $e->getMessage(),
            ]);

            return back()->with('error', 'Une erreur est survenue lors du rejet.');
        }
    }
}
