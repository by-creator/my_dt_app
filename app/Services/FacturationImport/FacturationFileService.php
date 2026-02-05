<?php

namespace App\Services\FacturationImport;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class FacturationFileService
{
    public function store(Request $request): array
    {
        $file = $request->file('facturation_file');
        $extension = strtolower($file->getClientOriginalExtension());

        $path = $file->storeAs(
            'imports',
            'facturation_' . now()->format('Ymd_His') . '.' . $extension,
            'local'
        );

        Log::info('📁 [FACTURATION] Fichier uploadé', [
            'original' => $file->getClientOriginalName(),
            'stored'   => $path,
            'ext'      => $extension,
        ]);

        return [$path, $extension];
    }

    public function fullPath(string $path): string
    {
        if (!Storage::disk('local')->exists($path)) {
            throw new \RuntimeException("Fichier introuvable : {$path}");
        }

        return str_replace('\\', '/', Storage::disk('local')->path($path));
    }
}
