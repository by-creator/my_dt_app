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

    public function indexRemise(Request $request)
    {
        $user = Auth::user();

        // 🎯 Statut selon rôle
        $statutsEnAttente = match ($user->role->name) {
            'FACTURATION' => [
                StatutDossier::REMISE_EN_ATTENTE_VALIDATION_FACTURATION
            ],
            'DIRECTION_GENERALE' => [
                StatutDossier::REMISE_EN_ATTENTE_VALIDATION_DIRECTION
            ],
            default => []
        };

        // 🔐 Sécurité
        if (empty($statutsEnAttente)) {
            abort(403);
        }

        // ✅ Liste à valider uniquement
        $remisesAValider = RattachementBl::whereIn('statut', $statutsEnAttente)
            ->latest()
            ->paginate(5);

        // ✅ Liste déjà traitées (séparée)
        $remisesTraitees = RattachementBl::whereIn('statut', [
            StatutDossier::REMISE_VALIDE,
            StatutDossier::REMISE_REJETE
        ])->latest()->get();
        $remisesTraitees = RattachementBl::whereIn('statut', [
            StatutDossier::REMISE_VALIDE,
            StatutDossier::REMISE_REJETE
        ])
            ->latest()
            ->paginate(3);   // ✅ au lieu de get()

        return view('rattachement_bl.index_remise', compact(
            'remisesAValider',
            'remisesTraitees',
            'user'
        ));
    }

    public function datalist(Request $request)
    {
        $field = $request->get('field');
        $query = $request->get('q');

        // 🔐 Sécurité : champs autorisés
        if (!in_array($field, ['bl'])) {
            return response()->json([]);
        }

        $results = RattachementBl::query()
            ->whereNotNull($field)
            ->when(
                $query,
                fn($q) =>
                $q->where($field, 'LIKE', "%{$query}%")
            )
            ->distinct()
            ->limit(3)
            ->pluck($field);

        return response()->json($results);
    }

    public function list()
    {
        return view('rattachement_bl.list', [
            'rattachements' => RattachementBl::where(
                'statut',
                StatutDossier::VALIDE,
                StatutDossier::REJETE
            )->latest()->get(),
            'users' => User::all(),
            'user' => Auth::user()
        ]);
    }

    public function listRemise()
    {
        return view('rattachement_bl.list_remise', [
            'rattachements' => RattachementBl::where(
                'statut',
                StatutDossier::REMISE_VALIDE,
                StatutDossier::REMISE_REJETE
            )->latest()->get(),
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

    public function validateRemise($id, Request $request)
    {
        $rattachement = $this->service->getOrFail($id);
        $this->service->ensureRemisePending($rattachement);

        $user = Auth::user();

        try {

            // ✅ CAS 1 : FACTURATION
            if ($user->role->name === 'FACTURATION') {

                $rattachement->statut = StatutDossier::REMISE_EN_ATTENTE_VALIDATION_DIRECTION;
                $rattachement->user_id = $user->id;
                $rattachement->save();

                return back()->with('valide', 'Remise transmise à la Direction pour validation.');
            }

            // ✅ CAS 2 : DIRECTION GENERALE
            if ($user->role->name === 'DIRECTION_GENERALE') {

                $request->validate([
                    'pourcentage' => 'required|numeric|min:0|max:100'
                ]);

                $pourcentage = $request->pourcentage;

                // Workflow
                $this->workflow->validateRemise($rattachement);

                // Envoi mail
                $this->mailer->sendRemiseValide($rattachement, $pourcentage);

                return back()->with('valide', 'Remise validée et email envoyé.');
            }

            abort(403);
        } catch (\Throwable $e) {

            Log::error('Erreur validation remise', [
                'id' => $id,
                'message' => $e->getMessage(),
            ]);

            return back()->with('error', 'Une erreur est survenue.');
        }
    }

    public function rejectRemise($id, Request $request)
    {
        $rattachement = $this->service->getOrFail($id);
        $this->service->ensureRemisePending($rattachement);

        $motif = $request->motif;

        if ($motif === 'autre' && !empty($request->autreMotif)) {
            $motif = $request->autreMotif;
        }

        try {
            $this->workflow->rejectRemise($rattachement);

            $this->mailer->sendRemiseRejete($rattachement, $motif);

            return back()->with('success', 'Dossier de remise rejeté avec succès !');
        } catch (\Throwable $e) {
            Log::error('Erreur rejet remise rattachement', [
                'id' => $id,
                'message' => $e->getMessage(),
            ]);

            return back()->with('error', 'Une erreur est survenue lors du rejet.');
        }
    }
}
