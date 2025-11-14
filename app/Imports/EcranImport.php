<?php

namespace App\Imports;

use App\Models\Ecran;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;


class EcranImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Ecran([
            'date_reception'   => $this->parseDate($row['date_reception']),
            'date_deploiement' => $this->parseDate($row['date_deploiement']),
            'service_tag'      => $row['service_tag'],
            'etiquetage'       => $row['etiquetage'],
            'service'          => $row['service'],
            'utilisateur'      => $row['utilisateur'],
        ]);
    }

    private function parseDate($value)
    {
        if (!$value || $value === '') {
            return null;
        }

        // CAS 1 : valeur texte "14/11/2025 08:49"
        try {
            return Carbon::createFromFormat('d/m/Y H:i', $value);
        } catch (\Exception $e) {
        }

        // CAS 2 : format sans heure "14/11/2025"
        try {
            return Carbon::createFromFormat('d/m/Y', $value);
        } catch (\Exception $e) {
        }

        // CAS 3 : valeur Excel sérialisée (nombre 45234…)
        if (is_numeric($value)) {
            return Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value));
        }

        return null;
    }
}
