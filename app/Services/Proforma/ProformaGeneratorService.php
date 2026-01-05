<?php

namespace App\Services\Proforma;

use App\Models\DossierFacturation;
use App\Enums\StatutDossier;
use Carbon\Carbon;

class ProformaGeneratorService
{
    public function generate(DossierFacturation $dossier, Carbon $date): void
    {
        $dossier->update([
            'date_proforma' => $date,
            'statut' => StatutDossier::EN_ATTENTE_PROFORMA,
            'date_en_attente_proforma' => now(),
        ]);
    }
}
