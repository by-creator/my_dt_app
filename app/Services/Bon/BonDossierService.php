<?php

namespace App\Services\Bon;

use App\Enums\StatutDossier;
use App\Models\DossierFacturation;

class BonDossierService
{
    public function getDossier(int $id): DossierFacturation
    {
        return DossierFacturation::findOrFail($id);
    }

    public function getRattachement(DossierFacturation $dossier)
    {
        $rattachement = $dossier->rattachement_bl;

        if (!$rattachement || !$rattachement->email) {
            abort(400, 'Aucun rattachement BL trouvé pour ce dossier.');
        }

        return $rattachement;
    }

    public function rejectBon(DossierFacturation $dossier): void
    {
        // retour à l’état précédent logique
        $dossier->statut = StatutDossier::FACTURE_VALIDE;

        $dossier->save();
    }
}
