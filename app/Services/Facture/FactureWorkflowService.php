<?php

namespace App\Services\Facture;

use App\Models\{
    DossierFacturation,
    DossierFacturationFacture
};

use App\Enums\StatutDossier;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;


class FactureWorkflowService
{

    public function validate(
        DossierFacturation $dossier,
        DossierFacturationFacture $facture
    ): void {
        $dossier->user_id = Auth::id();
        $dossier->statut = StatutDossier::FACTURE_VALIDE;

        $this->finalize($dossier, $facture);
    }

    public function validateComplement(
        DossierFacturation $dossier,
        DossierFacturationFacture $facture
    ): void {
        $dossier->user_id = Auth::id();
        $dossier->statut = StatutDossier::FACTURE_COMPLEMENTAIRE_VALIDE;

        $this->finalize($dossier, $facture);
    }

    private function finalize(
        DossierFacturation $dossier,
        DossierFacturationFacture $facture
    ): void {
        // 🔑 utilisateur
        $dossier->user_id = Auth::id();

        // 🔑 date de départ
        if (!$dossier->date_en_attente_facture) {
            $dossier->date_en_attente_facture = now();
        }

        // 🔑 calcul SAFE (jamais négatif)
        $seconds = Carbon::parse($dossier->date_en_attente_facture)
            ->diffInSeconds(now());

        $dossier->time_elapsed_facture =
            DossierFacturation::secondsToHms($seconds);

        // 🔑 synchronisation facture
        $facture->statut = $dossier->statut;
        $facture->time_elapsed = $dossier->time_elapsed_facture;
        $facture->user = Auth::user()->name;
        $facture->bl = $dossier->rattachement_bl?->bl ?? 'N/A';

        // 💾 sauvegarde atomique
        $dossier->save();
        $facture->save();
    }

}
