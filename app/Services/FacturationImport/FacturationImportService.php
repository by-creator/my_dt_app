<?php

namespace App\Services\FacturationImport;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class FacturationImportService
{
    public function __construct(
        private FacturationFileService $fileService,
        private FacturationStagingService $stagingService,
        private FacturationFinalizeService $finalizeService
    ) {}

    public function handle(Request $request): void
    {
        Log::info('📥 [FACTURATION] Début import');

        $request->validate([
            'facturation_file' => ['required', 'file', 'mimes:csv,xlsx'],
        ]);

        [$path, $ext] = $this->fileService->store($request);
        $fullPath = $this->fileService->fullPath($path);

        $this->stagingService->prepare();

        if ($ext === 'csv') {
            $this->stagingService->loadCsv($fullPath);
        } else {
            $this->stagingService->loadXlsx($fullPath);
        }

        $this->finalizeService->insert();
        $this->finalizeService->cleanup($path);

        Log::info('✅ [FACTURATION] Import terminé');
    }
}
