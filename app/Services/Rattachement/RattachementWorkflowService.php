<?php

namespace App\Services\Rattachement;

use App\Models\RattachementBl;
use App\Enums\StatutDossier;
use Illuminate\Support\Facades\Auth;

class RattachementWorkflowService
{
    public function validate(RattachementBl $rattachement): void
    {
        $rattachement->user_id = Auth::id();
        $rattachement->statut = StatutDossier::VALIDE;
        $rattachement->time_elapsed =
            $rattachement->created_at->diffForHumans(now(), true);

        $rattachement->save();

        // Création automatique du dossier de facturation
        $rattachement->dossierFacturation()->create([
            'statut' => $rattachement->statut
        ]);
    }

    public function reject(RattachementBl $rattachement): void
    {
        $rattachement->user_id = Auth::id();
        $rattachement->statut = StatutDossier::REJETE;
        $rattachement->time_elapsed =
            $rattachement->created_at->diffForHumans(now(), true);

        $rattachement->save();
    }
}
