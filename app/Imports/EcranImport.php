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
        if (!$value || trim($value) === '') {
            return null;
        }

        // CAS 1 : format complet texte ex: "14/11/2025 08:49"
        try {
            return Carbon::createFromFormat('d/m/Y H:i', $value);
        } catch (\Exception $e) {
        }

        // CAS 2 : format texte date simple ex: "14/11/2025"
        try {
            return Carbon::createFromFormat('d/m/Y', $value);
        } catch (\Exception $e) {
        }

        // CAS 3 : mois + année ex: "11/2025" ou "11-2025"
        try {
            return Carbon::createFromFormat('m/Y', $value)->startOfMonth();
        } catch (\Exception $e) {
        }

        try {
            return Carbon::createFromFormat('m-Y', $value)->startOfMonth();
        } catch (\Exception $e) {
        }

        // CAS 4 : année + mois ex: "2025-11" ou "2025/11"
        try {
            return Carbon::createFromFormat('Y-m', $value)->startOfMonth();
        } catch (\Exception $e) {
        }

        try {
            return Carbon::createFromFormat('Y/m', $value)->startOfMonth();
        } catch (\Exception $e) {
        }

        // CAS 5 : valeur Excel (numérique)
        if (is_numeric($value)) {
            return Carbon::instance(
                \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value)
            );
        }

        return null;
    }
}
