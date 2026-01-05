<?php

namespace App\Services\Upload;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DocumentUploadService
{
    public function upload(
        Request $request,
        string $field,
        string $folder,
        array $rules
    ): array {
        // ✅ validation dynamique
        $request->validate([
            "$field.*" => $rules,
        ]);

        $filesData = [];

        if (!$request->hasFile($field)) {
            return $filesData;
        }

        foreach ($request->file($field) as $file) {
            try {
                $originalName = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();
                $nameWithoutExt = pathinfo($originalName, PATHINFO_FILENAME);

                // nettoyage du nom
                $slug = Str::slug($nameWithoutExt);
                $finalName = $slug . '-' . time() . '.' . $extension;

                $path = Storage::disk('b2')->putFileAs(
                    "documents/$folder",
                    $file,
                    $finalName,
                    'public'
                );

                if (!$path) {
                    throw new \Exception('Upload échoué sur Backblaze.');
                }

                $filesData[] = [
                    'original' => $originalName,
                    'path' => $path,
                    'url' => rtrim(config('filesystems.b2_public_url'), '/') . '/' . $path,
                ];

                Log::info('[B2 UPLOAD OK]', compact('originalName', 'path'));

            } catch (\Throwable $e) {
                Log::error('[UPLOAD ERROR]', [
                    'message' => $e->getMessage(),
                ]);
                throw $e;
            }
        }

        return $filesData;
    }
}
