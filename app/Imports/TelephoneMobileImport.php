<?php

namespace App\Imports;

use App\Models\TelephoneMobile;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Carbon\Carbon;

class TelephoneMobileImport implements ToModel, WithStartRow
{
    public function startRow(): int
    {
        return 2;
    }

    public function model(array $row)
    {
        return new TelephoneMobile([
            'matricule'                  => $row[0]  ?? null,
            'nom'                        => $row[1]  ?? null,
            'prenom'                     => $row[2]  ?? null,
            'service'                    => $row[3]  ?? null,
            'destination'                => $row[4]  ?? null,
            'modele_telephone'           => $row[5]  ?? null,
            'reference_telephone'        => $row[6]  ?? null,
            'montant_ancien_forfait_ttc' => $row[7]  ?? null,
            'numero_sim'                 => $row[8]  ?? null,
            'formule_premium'            => $row[9]  ?? null,
            'montant_forfait_ttc'        => $row[10] ?? null,
            'code_puk'                   => $row[11] ?? null,

            // ✅ DATE SÉCURISÉE
            'acquisition_date'           => $this->parseDate($row[12] ?? null),

            'statut'                     => $row[13] ?? null,
            'cause_changement'           => $row[14] ?? null,
            'imsi'                       => $row[15] ?? null,
        ]);
    }

    /**
     * 🛡️ Nettoyage intelligent de la date
     */
    private function parseDate($value): ?string
    {
        if (empty($value)) {
            return null;
        }

        // Cas Excel numérique (ex: 44927)
        if (is_numeric($value)) {
            return Carbon::createFromTimestamp(
                ($value - 25569) * 86400
            )->format('Y-m-d');
        }

        // Cas YYYY-MM-DD ou DD/MM/YYYY
        try {
            return Carbon::parse($value)->format('Y-m-d');
        } catch (\Exception $e) {
            // ❌ valeur invalide → NULL
            return null;
        }
    }
}
