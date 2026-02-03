<?php

namespace App\Http\Controllers;

use App\Services\YardImport\YardImportService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class YardController extends Controller
{
    public function __construct(
        private YardImportService $yardImportService
    ) {}

    public function import(Request $request)
    {
        Log::info('📥 [YARD] Début import (Controller)');

        $this->yardImportService->handle($request);

        return back()->with('success', 'Import Yard terminé avec succès 🚀');
    }
}
