<?php

namespace App\Services\YardImport;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class YardImportService
{
    public function __construct(
        private YardFileService $fileService,
        private YardStagingService $stagingService,
        private YardFinalizeService $finalizeService
    ) {}

    public function handle(Request $request): void
    {
        Log::info('📥 [YARD] Début import (Service)');

        $request->validate([
            'file' => ['required', 'file', 'mimes:csv,xlsx'],
        ]);

        // 1️⃣ Upload
        [$storedPath, $extension] = $this->fileService->store($request);
        $fullPath = $this->fileService->getFullPath($storedPath);

        // 2️⃣ Préparation staging
        $this->stagingService->prepare();

        // 3️⃣ Import selon type
        if ($extension === 'csv') {
            $this->stagingService->loadCsv($fullPath);
        }

        if ($extension === 'xlsx') {
            $this->stagingService->loadXlsx($fullPath);
        }

        // 4️⃣ Insertion finale + cleanup
        $this->finalizeService->insertFinal();
        $this->finalizeService->cleanup($storedPath);

        Log::info('✅ [YARD] Import terminé avec succès');
    }
}
