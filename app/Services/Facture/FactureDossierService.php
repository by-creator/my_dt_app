<?php

namespace App\Services\Facture;

use App\Enums\StatutDossier;
use App\Models\DossierFacturation;

class FactureDossierService
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

    public function rejectFacture(DossierFacturation $dossier): void
    {
        // retour à l’état précédent logique
        $dossier->statut = StatutDossier::PROFORMA_VALIDE;

        $dossier->save();
    }
}
