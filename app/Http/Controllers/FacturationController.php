<?php

namespace App\Http\Controllers;

use App\Services\FacturationImport\FacturationImportService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class FacturationController extends Controller
{
    public function __construct(
        private FacturationImportService $service
    ) {}

    public function import(Request $request)
    {
        Log::info('📥 [FACTURATION] Controller import');

        $this->service->handle($request);

        return back()->with('success', 'Import facturation terminé ✅');
    }
}
