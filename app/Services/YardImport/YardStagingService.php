<?php

namespace App\Services\YardImport;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\YardXlsxImport;

class YardStagingService
{
    public function prepare(): void
    {
        DB::table('yard_stagings')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::statement('SET UNIQUE_CHECKS=0');

        Log::info('🧹 [YARD] Staging nettoyé');
    }

    /**
     * 🔴 CSV → LOAD DATA LOCAL INFILE
     * Le CSV contient déjà des dates complètes
     */
    public function load(string $fullPath): void
    {
        Log::info('🚀 [YARD] LOAD DATA LOCAL INFILE démarré');

        DB::statement("
        LOAD DATA LOCAL INFILE '{$fullPath}'
        INTO TABLE yard_stagings
        FIELDS TERMINATED BY ','
        ENCLOSED BY '\"'
        LINES TERMINATED BY '\n'
        IGNORE 1 LINES
        (
            @c1,  -- Terminal
            @c2,  -- Shipowner
            @c3,  -- ItemNumber
            @c4,  -- Item Type
            @c5,  -- Item Code
            @c6,  -- BL Number
            @c7,  -- Final Destination Country
            @c8,  -- Description
            @c9,  -- TEU
            @c10, -- Volume
            @c11, -- Weight
            @c12, -- Yard Zone Type
            @c13, -- Zone
            @c14, -- Type Veh
            @c15, -- Type De Marchandise
            @c16, -- POD
            @c17, -- Yard Zone
            @c18, -- Consignee
            @c19, -- Call Number

            @eta_year,
            @eta_month,
            @eta_day,

            @vessel,

            @vad_year,
            @vad_month,
            @vad_day,

            @cycle,
            @yard_quantity,
            @days_since_in,
            @dwelltime,
            @bae,
            @bloque
        )
        SET
            terminal = @c1,
            shipowner = @c2,
            item_number = @c3,
            item_type = @c4,
            item_code = @c5,
            bl_number = @c6,
            final_destination_country = @c7,
            description = @c8,
            teu = @c9,
            volume = @c10,
            weight = @c11,
            yard_zone_type = @c12,
            zone = @c13,
            type_veh = @c14,
            type_de_marchandise = @c15,
            pod = @c16,
            yard_zone = @c17,
            consignee = @c18,
            call_number = @c19,

            -- ✅ ETA (Year + Month name + Day)
            eta = STR_TO_DATE(
                CONCAT(@eta_year,'-',@eta_month,'-',LPAD(@eta_day,2,'0')),
                '%Y-%M-%d'
            ),

            vessel = @vessel,

            -- ✅ Vessel arrival date
            vessel_arrival_date = STR_TO_DATE(
                CONCAT(@vad_year,'-',@vad_month,'-',LPAD(@vad_day,2,'0')),
                '%Y-%M-%d'
            ),

            cycle = @cycle,
            yard_quantity = @yard_quantity,
            days_since_in = @days_since_in,
            dwelltime = @dwelltime,
            bae = @bae,
            bloque = @bloque,

            created_at = NOW(),
            updated_at = NOW()
    ");

        Log::info('✅ [YARD] LOAD DATA terminé', [
            'rows' => DB::table('yard_stagings')->count(),
        ]);
    }


    /**
     * 🟢 XLSX → Import Laravel Excel
     * (NE PAS TOUCHER, il fonctionne déjà)
     */
    public function loadFromXlsx(string $fullPath): void
    {
        Log::info('📘 [YARD] Import XLSX démarré');

        Excel::import(new YardXlsxImport, $fullPath);

        Log::info('✅ [YARD] Import XLSX terminé', [
            'rows' => DB::table('yard_stagings')->count(),
        ]);
    }
}
