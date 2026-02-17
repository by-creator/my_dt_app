<?php

namespace App\Services\YardImport;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\YardXlsxImport;

class YardStagingService
{
    /**
     * 🔹 Nettoie la table staging avant import
     */
    public function prepare(): void
    {
        DB::table('yard_stagings')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::statement('SET UNIQUE_CHECKS=0');

        Log::info('🧹 [YARD] Staging nettoyé');
    }

    /**
     * 🔴 Import CSV ultra rapide via LOAD DATA LOCAL INFILE
     * 
     * @param string $fullPath Chemin complet du fichier CSV
     */
    public function loadCsv(string $fullPath): void
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
            @terminal,
            @shipowner,
            @item_number,
            @item_type,
            @item_code,
            @bl_number,
            @final_destination_country,
            @description,
            @teu,
            @volume,
            @weight,
            @yard_zone_type,
            @zone,
            @type_veh,
            @type_de_marchandise,
            @pod,
            @yard_zone,
            @consignee,
            @call_number,
            @vessel,
            @eta,
            @vessel_arrival_date,
            @cycle,
            @yard_quantity,
            @days_since_in,
            @dwelltime,
            @bloque,
            @bae,
            @date,
            @time,
            @chauffeur,
            @permis,
            @pointeur,
            @responsable,
            @reserve
        )
        SET
            terminal = @terminal,
            shipowner = @shipowner,
            item_number = @item_number,
            item_type = @item_type,
            item_code = @item_code,
            bl_number = @bl_number,
            final_destination_country = @final_destination_country,
            description = @description,
            teu = @teu,
            volume = @volume,
            weight = @weight,
            yard_zone_type = @yard_zone_type,
            zone = @zone,
            type_veh = @type_veh,
            type_de_marchandise = @type_de_marchandise,
            pod = @pod,
            yard_zone = @yard_zone,
            consignee = @consignee,
            call_number = @call_number,
            vessel = @vessel,
            eta = @eta,
            vessel_arrival_date = @vessel_arrival_date,
            cycle = @cycle,
            yard_quantity = @yard_quantity,
            days_since_in = @days_since_in,
            dwelltime = @dwelltime,
            bloque = @bloque,
            bae = @bae,
            date = @date,
            time = @time,
            chauffeur = @chauffeur,
            permis = @permis,
            pointeur = @pointeur,
            responsable = @responsable,
            reserve = @reserve,
            created_at = NOW(),
            updated_at = NOW()
        ");

        Log::info('✅ [YARD] LOAD DATA terminé', [
            'rows' => DB::table('yard_stagings')->count(),
        ]);
    }

    /**
     * 🟢 Import XLSX via Laravel Excel
     * 
     * @param string $fullPath Chemin complet du fichier XLSX
     */
    public function loadXlsx(string $fullPath): void
    {
        Log::info('📘 [YARD] Import XLSX démarré');

        Excel::import(new YardXlsxImport, $fullPath);

        Log::info('✅ [YARD] Import XLSX terminé', [
            'rows' => DB::table('yard_stagings')->count(),
        ]);
    }
}
