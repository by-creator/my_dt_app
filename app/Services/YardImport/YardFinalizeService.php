<?php

namespace App\Services\YardImport;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class YardFinalizeService
{
    public function insertFinal(): void
    {
        Log::info('📦 [YARD] Insertion finale démarrée');

        DB::statement("
            INSERT INTO yards
            SELECT *
            FROM yard_stagings s
            WHERE NOT EXISTS (
                SELECT 1 FROM yards y
                WHERE y.item_number = s.item_number
            )
        ");

        Log::info('🏁 [YARD] Insertion finale terminée');
    }

    public function cleanup(string $storedPath): void
    {
        // 🔥 Nettoyage staging APRÈS import
        DB::table('yard_stagings')->truncate();

        // ♻️ Réactivation des checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
        DB::statement('SET UNIQUE_CHECKS=1');

        // 🗑️ Suppression du fichier importé
        Storage::disk('local')->delete($storedPath);

        Log::info('🧽 [YARD] Cleanup terminé', [
            'staging_truncated' => true,
            'file_deleted' => $storedPath,
        ]);
    }
}
