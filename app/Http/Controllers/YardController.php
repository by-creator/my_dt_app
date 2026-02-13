<?php

namespace App\Http\Controllers;

use App\Services\YardImport\YardImportService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Models\Yard;

class YardController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        $filters = ['item_number'];

        $query = Yard::query();

        foreach ($filters as $field) {
            if ($request->filled($field)) {
                $query->where($field, $request->$field);
            }
        }

        $yards = $query
            ->latest()
            ->paginate(3)
            ->withQueryString();

        return view('rapport.yard', compact('user', 'yards'));
    }

    public function datalist(Request $request)
    {
        $field = $request->get('field'); 
        $query = $request->get('q');

        // 🔐 Sécurité : champs autorisés
        if (!in_array($field, ['item_number' ])) {
            return response()->json([]);
        }

        $results = Yard::query()
            ->whereNotNull($field)
            ->when(
                $query,
                fn($q) =>
                $q->where($field, 'LIKE', "%{$query}%")
            )
            ->distinct()
            ->limit(10) // ⚡ limite pour perf
            ->pluck($field);

        return response()->json($results);
    }
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
