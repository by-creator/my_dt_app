<?php

namespace App\Services\Rattachement;

use App\Models\RattachementBl;
use App\Enums\StatutDossier;

class RattachementService
{
    public function getOrFail(int $id): RattachementBl
    {
        return RattachementBl::findOrFail($id);
    }

    public function ensurePending(RattachementBl $rattachement): void
    {
        if ($rattachement->statut !== StatutDossier::EN_ATTENTE_VALIDATION) {
            abort(403, 'Dossier déjà traité.');
        }
    }

    public function ensureRemisePending(RattachementBl $rattachement): void
    {
        if (!in_array($rattachement->statut, [
            StatutDossier::REMISE_EN_ATTENTE_VALIDATION_FACTURATION,
            StatutDossier::REMISE_EN_ATTENTE_VALIDATION_DIRECTION
        ])) {
            abort(403, 'Dossier déjà traité.');
        }
    }
}
