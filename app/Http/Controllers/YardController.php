<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Excel as ExcelExcel;

class YardController extends Controller
{
    public function import(Request $request)
    {
        $request->validate([
            'file' => ['required', 'file', 'mimes:csv,xlsx', 'max:102400'], // 100MB
        ]);

        DB::disableQueryLog();

        // 1️⃣ Stockage du fichier uploadé
        $uploadedFile = $request->file('file');
        $extension = $uploadedFile->getClientOriginalExtension();

        $filename = 'yard_' . now()->format('Ymd_His');
        $storedPath = $uploadedFile->storeAs('imports', $filename . '.' . $extension);

        // 2️⃣ Conversion XLSX → CSV si nécessaire
        if ($extension === 'xlsx') {
            $csvPath = "imports/{$filename}.csv";

            Excel::store(
                new class implements \Maatwebsite\Excel\Concerns\FromCollection {
                    public function collection()
                    {
                        return collect();
                    }
                },
                $csvPath,
                null,
                ExcelExcel::CSV
            );

            Excel::convert(
                storage_path("app/{$storedPath}"),
                storage_path("app/{$csvPath}"),
                ExcelExcel::XLSX,
                ExcelExcel::CSV
            );

            Storage::delete($storedPath);
            $storedPath = $csvPath;
        }

        // Chemin absolu compatible MySQL
        $fullPath = str_replace('\\', '/', storage_path('app/' . $storedPath));

        // 3️⃣ Nettoyage staging
        DB::table('yard_stagings')->truncate();

        // 4️⃣ Optimisations MySQL
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::statement('SET UNIQUE_CHECKS=0');

        // 5️⃣ IMPORT MASSIF CSV → STAGING 🚀
        DB::statement("
            LOAD DATA LOCAL INFILE '{$fullPath}'
            INTO TABLE yard_stagings
            FIELDS TERMINATED BY ','
            ENCLOSED BY '\"'
            LINES TERMINATED BY '\n'
            IGNORE 1 LINES
            (
                Terminal,
                Shipowner,
                ItemNumber,
                Item_Type,
                Item_Code,
                BlNumber,
                FinalDestinationCountry,
                Description_,
                TEU,
                Volume,
                Weight_,
                YardZoneType,
                Zone,
                Type_Veh,
                TypeDeMarchandise,
                POD,
                YardZone,
                consignee,
                callNumber,
                Vessel,
                ETA,
                vesselarrivaldate,
                Cycle,
                @yard_quantity,
                @days_since_in,
                Dwelltime,
                @bloque,
                @date,
                @time,
                bae,
                client,
                chauffeur,
                permis,
                pointeur,
                responsable,
                reserve
            )
            SET
                `Yard Quantity` = @yard_quantity,
                `DAYS SINCE IN` = @days_since_in,
                `Bloqué` = @bloque,
                date = STR_TO_DATE(@date, '%Y-%m-%d'),
                time = STR_TO_DATE(@time, '%H:%i:%s'),
                created_at = NOW(),
                updated_at = NOW()
        ");

        // 6️⃣ INSERT FINAL → yards (sans doublons)
        DB::statement("
            INSERT INTO yards (
                Terminal, Shipowner, ItemNumber, Item_Type, Item_Code, BlNumber,
                FinalDestinationCountry, Description_, TEU, Volume, Weight_,
                YardZoneType, Zone, Type_Veh, TypeDeMarchandise, POD, YardZone,
                consignee, callNumber, Vessel, ETA, vesselarrivaldate, Cycle,
                `Yard Quantity`, `DAYS SINCE IN`, Dwelltime, Bloqué, date, time,
                bae, client, chauffeur, permis, pointeur, responsable, reserve
            )
            SELECT
                a.Terminal, a.Shipowner, a.ItemNumber, a.Item_Type, a.Item_Code,
                a.BlNumber, a.FinalDestinationCountry, a.Description_, a.TEU,
                a.Volume, a.Weight_, a.YardZoneType, a.Zone, a.Type_Veh,
                a.TypeDeMarchandise, a.POD, a.YardZone, a.consignee, a.callNumber,
                a.Vessel, a.ETA, a.vesselarrivaldate, a.Cycle,
                a.`Yard Quantity`, a.`DAYS SINCE IN`, a.Dwelltime, a.Bloqué,
                a.date, a.time, a.bae, a.client, a.chauffeur, a.permis,
                a.pointeur, a.responsable, a.reserve
            FROM yard_stagings a
            WHERE NOT EXISTS (
                SELECT 1 FROM yards b WHERE b.ItemNumber = a.ItemNumber
            )
        ");

        // 7️⃣ Cleanup
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
        DB::statement('SET UNIQUE_CHECKS=1');
        Storage::delete($storedPath);

        return back()->with('success', 'Import terminé avec succès 🚀');
    }
}
