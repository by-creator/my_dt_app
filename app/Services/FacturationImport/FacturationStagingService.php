<?php

namespace App\Services\FacturationImport;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\FacturationXlsxImport;

class FacturationStagingService
{
    public function prepare(): void
    {
        DB::table('facturation_stagings')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::statement('SET UNIQUE_CHECKS=0');

        Log::info('🧹 [FACTURATION] Staging nettoyé');
    }

    public function loadCsv(string $fullPath): void
    {
        Log::info('🚀 [FACTURATION] LOAD DATA CSV');

        DB::statement("
            LOAD DATA LOCAL INFILE '{$fullPath}'
            INTO TABLE facturation_stagings
            FIELDS TERMINATED BY ','
            ENCLOSED BY '\"'
            LINES TERMINATED BY '\n'
            IGNORE 1 LINES
        ");

        Log::info('✅ [FACTURATION] CSV chargé', [
            'rows' => DB::table('facturation_stagings')->count()
        ]);
    }

    public function loadXlsx(string $fullPath): void
    {
        Log::info('📘 [FACTURATION] Import XLSX');

        Excel::import(new FacturationXlsxImport, $fullPath);

        Log::info('✅ [FACTURATION] XLSX chargé', [
            'rows' => DB::table('facturation_stagings')->count()
        ]);
    }
}
