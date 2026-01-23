<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class ConsolidateOrdreApprocheJob implements ShouldQueue
{
    use Queueable;

    public function __construct(
        protected string $path
    ) {}

    public function handle(): void
    {
        Log::info('🚀 Début consolidation ordre_approches');

        DB::statement("
            INSERT INTO ordre_approches (
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
                date,
                time,
                bae,
                client,
                chauffeur,
                permis,
                pointeur,
                responsable,
                reserve
            )
            SELECT
                a.terminal,
                a.shipowner,
                a.item_number,
                a.item_type,
                a.item_code,
                a.bl_number,
                a.final_destination_country,
                a.description,
                a.teu,
                a.volume,
                a.weight,
                a.yard_zone_type,
                a.zone,
                a.type_veh,
                a.type_de_marchandise,
                a.pod,
                a.yard_zone,
                a.consignee,
                a.call_number,
                a.vessel,
                a.eta,
                a.vessel_arrival_date,
                a.cycle,
                a.yard_quantity,
                a.days_since_in,
                a.dwelltime,
                a.date,
                a.time,
                a.bae,
                a.client,
                a.chauffeur,
                a.permis,
                a.pointeur,
                a.responsable,
                a.reserve
            FROM ordre_approches_staging a
            WHERE NOT EXISTS (
                SELECT 1
                FROM ordre_approches b
                WHERE b.item_number = a.item_number
            )
        ");

        DB::table('ordre_approches_staging')->truncate();
        Storage::disk('b2')->delete($this->path);

        Log::info('✅ Consolidation ordre_approches terminée + fichier supprimé');
    }
}
