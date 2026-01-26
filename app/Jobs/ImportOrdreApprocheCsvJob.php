<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ImportOrdreApprocheCsvJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /** 🔥 IMPORTANT : PAS private, PAS typed */
    protected string $localPath;
    protected string $b2Path;

    public function __construct(string $localPath, string $b2Path)
    {
        $this->localPath = $localPath;
        $this->b2Path = $b2Path;
    }

    public function handle(): void
    {
        Log::info('🚀 Début import CSV réel', [
            'local' => $this->localPath,
            'b2'    => $this->b2Path,
        ]);

        $filePath = Storage::disk('local')->path($this->localPath);

        if (!file_exists($filePath)) {
            Log::error('❌ CSV local introuvable', ['path' => $filePath]);
            return;
        }

        $handle = fopen($filePath, 'r');

        // ignorer en-tête
        fgetcsv($handle, 0, ';');

        $batch = [];

        while (($row = fgetcsv($handle, 0, ';')) !== false) {

            if (empty($row[2])) {
                continue;
            }

            $batch[] = [
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
            ];

            if (count($batch) === 1000) {
                DB::table('ordre_approches_staging')->insert($batch);
                $batch = [];
            }
        }

        if (!empty($batch)) {
            DB::table('ordre_approches_staging')->insert($batch);
        }

        fclose($handle);

        // 🧹 nettoyage
        Storage::disk('local')->delete($this->localPath);
        Storage::disk('b2')->delete($this->b2Path);

        Log::info('✅ Import CSV terminé');
    }
}
