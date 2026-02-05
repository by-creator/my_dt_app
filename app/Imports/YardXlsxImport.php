<?php

namespace App\Imports;

use App\Models\YardStaging;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class YardXlsxImport implements ToModel, WithStartRow
{
    /**
     * 🔥 Ignore la ligne 1 (header)
     */
    public function startRow(): int
    {
        return 2;
    }

    public function model(array $row)
    {
        try {
            return new YardStaging([
                'terminal' => $row[0] ?? null,
                'shipowner' => $row[1] ?? null,
                'item_number' => $row[2] ?? null,
                'item_type' => $row[3] ?? null,
                'item_code' => $row[4] ?? null,
                'bl_number' => $row[5] ?? null,
                'final_destination_country' => $row[6] ?? null,
                'description' => $row[7] ?? null,
                'teu' => $row[8] ?? null,
                'volume' => $row[9] ?? null,
                'weight' => $row[10] ?? null,
                'yard_zone_type' => $row[11] ?? null,
                'zone' => $row[12] ?? null,
                'type_veh' => $row[13] ?? null,
                'type_de_marchandise' => $row[14] ?? null,
                'pod' => $row[15] ?? null,
                'yard_zone' => $row[16] ?? null,
                'consignee' => $row[17] ?? null,
                'call_number' => $row[18] ?? null,

                // ETA
                'eta' => $this->makeDate(
                    $row[19] ?? null,
                    $row[20] ?? null,
                    $row[21] ?? null
                ),

                'vessel' => $row[22] ?? null,

                // Vessel arrival
                'vessel_arrival_date' => $this->makeDate(
                    $row[23] ?? null,
                    $row[24] ?? null,
                    $row[25] ?? null
                ),

                // ✅ ICI EST LA CORRECTION MAJEURE
                'cycle' => $row[26] ?? null,
                'yard_quantity' => $row[27] ?? null,
                'days_since_in' => $row[28] ?? null,
                'dwelltime' => $row[29] ?? null,
                'bae' => $row[30] ?? null,
                'bloque' => $this->toBool($row[31] ?? null),

                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } catch (\Throwable $e) {
            Log::error('❌ [YARD][XLSX] Ligne ignorée', [
                'row' => $row,
                'error' => $e->getMessage(),
            ]);

            return null;
        }
    }

    /**
     * 🔧 Construit une date depuis YEAR / MONTH / DAY
     */
    private function buildDate($year, $month, $day): ?string
    {
        if (!$year || !$month || !$day) {
            return null;
        }

        try {
            return date(
                'Y-m-d',
                strtotime("$year $month $day")
            );
        } catch (\Throwable) {
            return null;
        }
    }

    private function makeDate($year, $month, $day): ?string
    {
        if (!$year || !$month || !$day) {
            return null;
        }

        try {
            return \Carbon\Carbon::createFromDate(
                (int) $year,
                is_numeric($month) ? (int) $month : date('n', strtotime($month)),
                (int) $day
            )->format('Y-m-d');
        } catch (\Throwable) {
            return null;
        }
    }

    private function toBool($value): bool
    {
        return in_array(strtolower((string) $value), ['1', 'true', 'oui', 'vrai'], true);
    }
}
