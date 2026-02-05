<?php

namespace App\Services\YardImport;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class YardFileService
{
    public function store(Request $request): array
    {
        $file = $request->file('file');
        $extension = strtolower($file->getClientOriginalExtension());

        $storedPath = $file->storeAs(
            'imports',
            'yard_' . now()->format('Ymd_His') . '.' . $extension,
            'local'
        );

        Log::info('📁 [YARD] Fichier uploadé', [
            'original_name' => $file->getClientOriginalName(),
            'stored_path'   => $storedPath,
            'extension'     => $extension,
            'size'          => $file->getSize(),
        ]);

        return [$storedPath, $extension];
    }

    public function getFullPath(string $storedPath): string
    {
        $disk = Storage::disk('local');

        if (!$disk->exists($storedPath)) {
            throw new \RuntimeException("Fichier introuvable : {$storedPath}");
        }

        $fullPath = str_replace('\\', '/', $disk->path($storedPath));

        Log::info('📄 [YARD] Chemin fichier résolu', [
            'stored_path' => $storedPath,
            'full_path'   => $fullPath,
        ]);

        return $fullPath;
    }
}
