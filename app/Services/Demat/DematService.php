<?php

namespace App\Services\Demat;

use App\Models\RattachementBl;
use App\Enums\StatutDossier;

class DematService
{
    public function blEnAttente(string $bl): bool
    {
        return RattachementBl::where('bl', $bl)
            ->where('statut', StatutDossier::EN_ATTENTE_VALIDATION)
            ->exists();
    }

    public function blValide(string $bl): bool
    {
        return RattachementBl::where('bl', $bl)
            ->where('statut', StatutDossier::VALIDE)
            ->exists();
    }

    public function createRattachement(array $data): RattachementBl
    {
        return RattachementBl::create($data);
    }
}
