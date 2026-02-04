<?php

namespace App\Services\YardImport;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class YardStagingService
{
    public function prepare(): void
    {
        DB::table('yard_stagings')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::statement('SET UNIQUE_CHECKS=0');

        Log::info('🧹 [YARD] Staging nettoyé');
    }

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

        @eta_day, @eta_month, @eta_year,

        @c20, -- Vessel

        @vad_day, @vad_month, @vad_year,

        @c21, -- Cycle
        @c22, -- Yard Quantity
        @c23, -- Days Since In
        @c24, -- Dwelltime
        @c25, -- BAE
        @c26, -- Bloque
        @c27, -- Client
        @c28, -- Date
        @c29, -- Time
        @c30, -- Chauffeur
        @c31, -- Permis
        @c32, -- Pointeur
        @c33, -- Responsable
        @c34  -- Reserve
    )
    SET
        terminal = @c1,
        shipowner = @c2,
        item_number = @c3,      -- ✅ FIX
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

        eta = STR_TO_DATE(
            CONCAT(@eta_year,'-',LPAD(@eta_month,2,'0'),'-',LPAD(@eta_day,2,'0')),
            '%Y-%m-%d'
        ),

        vessel = @c20,

        vessel_arrival_date = STR_TO_DATE(
            CONCAT(@vad_year,'-',LPAD(@vad_month,2,'0'),'-',LPAD(@vad_day,2,'0')),
            '%Y-%m-%d'
        ),

        cycle = @c21,
        yard_quantity = @c22,
        days_since_in = @c23,
        dwelltime = @c24,
        bae = @c25,
        client = @c26,
        bloque = @c27,
        date = STR_TO_DATE(@c28,'%Y-%m-%d'),
        time = STR_TO_DATE(@c29,'%H:%i:%s'),
        chauffeur = @c30,
        permis = @c31,
        pointeur = @c32,
        responsable = @c33,
        reserve = @c34,
        created_at = NOW(),
        updated_at = NOW()
");


        $rows = DB::table('yard_stagings')->count();

        Log::info('✅ [YARD] LOAD DATA terminé', [
            'rows_in_staging' => $rows,
        ]);
    }
}
