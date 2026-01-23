<?php

namespace App\Imports;

use App\Models\OrdreApprocheStaging;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\{
    ToModel,
    WithChunkReading,
    WithBatchInserts,
};

class OrdreApprocheStagingImport implements
    ToModel,
    WithChunkReading,
    WithBatchInserts,
    ShouldQueue
{
  

    public function chunkSize(): int
    {
        return 1000;
    }

    public function batchSize(): int
    {
        return 1000;
    }

    public function model(array $row)
    {

        Log::info('📄 Ligne lue', $row);

        // ignorer lignes vides
        if (empty($row[2])) {
            return null;
        }

        return new OrdreApprocheStaging([
            'terminal'                    => $row[0] ?? null,
            'shipowner'                   => $row[1] ?? null,
            'item_number'                 => $row[2] ?? null,
            'item_type'                   => $row[3] ?? null,
            'item_code'                   => $row[4] ?? null,
            'bl_number'                   => $row[5] ?? null,
            'final_destination_country'   => $row[6] ?? null,
            'description'                 => $row[7] ?? null,
            'teu'                         => $row[8] ?? null,
            'volume'                      => $row[9] ?? null,
            'weight'                      => $row[10] ?? null,
            'yard_zone_type'              => $row[11] ?? null,
            'zone'                        => $row[12] ?? null,
            'type_veh'                    => $row[13] ?? null,
            'type_de_marchandise'         => $row[14] ?? null,
            'pod'                         => $row[15] ?? null,
            'yard_zone'                   => $row[16] ?? null,
            'consignee'                   => $row[17] ?? null,
            'call_number'                 => $row[18] ?? null,
            'vessel'                      => $row[19] ?? null,
            'eta'                         => $row[20] ?? null,
            'vessel_arrival_date'         => $row[21] ?? null,
            'cycle'                       => $row[22] ?? null,
            'yard_quantity'               => $row[23] ?? null,
            'days_since_in'               => $row[24] ?? null,
            'dwelltime'                   => $row[25] ?? null,
        ]);
    }
}
