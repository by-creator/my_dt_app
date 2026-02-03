<?php

namespace App\Services\YardImport;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Excel as ExcelExcel;

class YardFileService
{
    public function store(Request $request): array
    {
        $file = $request->file('file');
        $extension = strtolower($file->getClientOriginalExtension());

        $baseName = 'yard_' . now()->format('Ymd_His');
        $storedPath = $file->storeAs(
            'imports',
            "{$baseName}.{$extension}",
            'local' // 👈 DISK FORCÉ
        );
        Log::info('🧪 [YARD] Debug disks', [
            'default_disk' => config('filesystems.default'),
            'exists_local' => Storage::disk('local')->exists($storedPath),
            'exists_public' => Storage::disk('public')->exists($storedPath),
        ]);



        Log::info('📁 [YARD] Fichier uploadé', [
            'original_name' => $file->getClientOriginalName(),
            'stored_path'   => $storedPath,
            'extension'     => $extension,
            'size'          => $file->getSize(),
        ]);

        return [$storedPath, $extension];
    }

    public function convertXlsxToCsvIfNeeded(string $storedPath, string $extension): string
    {
        if ($extension !== 'xlsx') {
            return $storedPath;
        }

        $csvPath = str_replace('.xlsx', '.csv', $storedPath);

        Excel::convert(
            storage_path("app/{$storedPath}"),
            storage_path("app/{$csvPath}"),
            ExcelExcel::XLSX,
            ExcelExcel::CSV
        );

        Storage::delete($storedPath);

        Log::info('🔁 [YARD] XLSX converti en CSV', [
            'csv_path' => $csvPath,
        ]);

        return $csvPath;
    }

    public function getFullPath(string $storedPath): string
    {
        // On force le disk utilisé lors du store()
        $disk = Storage::disk('local');

        if (!$disk->exists($storedPath)) {
            throw new \RuntimeException("Fichier CSV introuvable (disk local) : {$storedPath}");
        }

        // Chemin absolu réel du fichier
        $fullPath = str_replace(
            '\\',
            '/',
            $disk->path($storedPath)
        );

        Log::info('📄 [YARD] Chemin fichier résolu', [
            'stored_path' => $storedPath,
            'full_path'   => $fullPath,
        ]);

        return $fullPath;
    }
}
