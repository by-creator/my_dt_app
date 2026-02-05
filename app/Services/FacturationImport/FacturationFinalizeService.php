<?php

namespace App\Services\FacturationImport;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class FacturationFinalizeService
{
    public function insert(): void
    {
        Log::info('📦 [FACTURATION] Insertion finale');

        DB::statement("
            INSERT INTO facturations
            SELECT *
            FROM facturation_stagings s
            WHERE NOT EXISTS (
                SELECT 1 FROM facturations f
                WHERE f.invoice_number = s.invoice_number
            )
        ");
    }

    public function cleanup(string $path): void
    {
        DB::table('facturation_stagings')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
        DB::statement('SET UNIQUE_CHECKS=1');

        Storage::disk('local')->delete($path);

        Log::info('🧽 [FACTURATION] Cleanup terminé');
    }
}
