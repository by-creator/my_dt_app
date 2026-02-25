<?php

namespace App\Services\YardImport;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class YardFinalizeService
{
    public function insertFinal(): void
    {
        Log::info('📦 [YARD] Insertion finale UPSERT');

        DB::statement("
        INSERT INTO yards (
            terminal,
            shipowner,
            item_number,
            item_type,
            item_code,
            bl_number,
            final_destination_country,
            description,
            teu,
            volume,
            weight,
            yard_zone_type,
            zone,
            type_veh,
            type_de_marchandise,
            pod,
            yard_zone,
            consignee,
            call_number,
            vessel,
            eta,
            vessel_arrival_date,
            cycle,
            yard_quantity,
            days_since_in,
            dwelltime,
            bloque,
            bae,
            date,
            time,
            chauffeur,
            permis,
            pointeur,
            responsable,
            reserve,
            created_at,
            updated_at
        )
        SELECT
            terminal,
            shipowner,
            item_number,
            item_type,
            item_code,
            bl_number,
            final_destination_country,
            description,
            teu,
            volume,
            weight,
            yard_zone_type,
            zone,
            type_veh,
            type_de_marchandise,
            pod,
            yard_zone,
            consignee,
            call_number,
            vessel,
            eta,
            vessel_arrival_date,
            cycle,
            yard_quantity,
            days_since_in,
            dwelltime,
            bloque,
            bae,
            NULLIF(TRIM(date), '0000-00-00') as date,
            NULLIF(TRIM(time), '') as time,
            chauffeur,
            permis,
            pointeur,
            responsable,
            reserve,
            NOW(),
            NOW()
        FROM yard_stagings
        ON DUPLICATE KEY UPDATE
            terminal = VALUES(terminal),
            shipowner = VALUES(shipowner),
            item_type = VALUES(item_type),
            item_code = VALUES(item_code),
            bl_number = VALUES(bl_number),
            final_destination_country = VALUES(final_destination_country),
            description = VALUES(description),
            teu = VALUES(teu),
            volume = VALUES(volume),
            weight = VALUES(weight),
            yard_zone_type = VALUES(yard_zone_type),
            zone = VALUES(zone),
            type_veh = VALUES(type_veh),
            type_de_marchandise = VALUES(type_de_marchandise),
            pod = VALUES(pod),
            yard_zone = VALUES(yard_zone),
            consignee = VALUES(consignee),
            call_number = VALUES(call_number),
            vessel = VALUES(vessel),
            eta = VALUES(eta),
            vessel_arrival_date = VALUES(vessel_arrival_date),
            cycle = VALUES(cycle),
            yard_quantity = VALUES(yard_quantity),
            days_since_in = VALUES(days_since_in),
            dwelltime = VALUES(dwelltime),
            bloque = VALUES(bloque),
            bae = VALUES(bae),
            date = VALUES(date),
            time = VALUES(time),
            chauffeur = VALUES(chauffeur),
            permis = VALUES(permis),
            pointeur = VALUES(pointeur),
            responsable = VALUES(responsable),
            reserve = VALUES(reserve),
            updated_at = NOW()
    ");
    }

    public function cleanup(string $storedPath): void
    {
        DB::table('yard_stagings')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
        DB::statement('SET UNIQUE_CHECKS=1');

        Storage::disk('local')->delete($storedPath);

        Log::info('🧽 [YARD] Cleanup terminé');
    }
}
