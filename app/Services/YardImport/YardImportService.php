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
        DB::disableQueryLog();
        Log::info('📥 [YARD] Début import (Service)');

        try {
            $this->validate($request);

            [$storedPath, $extension] = $this->fileService->store($request);

            $storedPath = $this->fileService->convertXlsxToCsvIfNeeded($storedPath, $extension);

            $fullPath = $this->fileService->getFullPath($storedPath);

            $this->stagingService->prepare();
            $this->stagingService->load($fullPath);

            $this->finalizeService->insertFinal();
            $this->finalizeService->cleanup($storedPath);

            Log::info('✅ [YARD] Import terminé avec succès');

        } catch (\Throwable $e) {

            Log::error('❌ [YARD] Erreur import', [
                'message' => $e->getMessage(),
                'file'    => $e->getFile(),
                'line'    => $e->getLine(),
            ]);

            throw $e;
        }
    }

    private function validate(Request $request): void
    {
        $request->validate([
            'file' => ['required', 'file', 'mimes:csv,xlsx', 'max:102400'],
        ]);

        Log::info('✅ [YARD] Validation OK');
    }
}
