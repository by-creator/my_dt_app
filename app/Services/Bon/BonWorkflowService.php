<?php

namespace App\Services\Bon;

use App\Models\{
    DossierFacturation,
    DossierFacturationBon
};
use App\Enums\StatutDossier;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class BonWorkflowService
{
   public function validate(
        DossierFacturation $dossier,
        DossierFacturationBon $bon
    ): void {
        $dossier->user_id = Auth::id();
        $dossier->statut = StatutDossier::BAD_VALIDE;

        $this->finalize($dossier, $bon);
    }

    private function finalize(
        DossierFacturation $dossier,
        DossierFacturationBon $bon
    ): void {
        if (!$dossier->date_en_attente_bon) {
            $dossier->date_en_attente_bon = now();
        }

        $seconds = now()->diffInSeconds($dossier->date_en_attente_bon);
        $dossier->time_elapsed_bon = DossierFacturation::secondsToHms($seconds);

       
        $bon->user = Auth::user()->name;
        $bon->bl = $dossier->rattachement_bl?->bl;
        $bon->statut = $dossier->statut;
        $bon->time_elapsed = $dossier->time_elapsed_bon;

        $dossier->save();
        $bon->save();
    }
}
