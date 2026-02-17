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
        if (!in_array($field, ['item_number'])) {
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

    public function convert(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,txt'
        ]);

        $file = $request->file('file');

        // 🔥 Lire le fichier
        $handle = fopen($file->getRealPath(), 'r');

        $data = [];

        while (($row = fgetcsv($handle, 1000, ',')) !== false) {

            foreach ($row as &$value) {

                if (strtoupper($value) === 'TRUE') {
                    $value = 1;
                }

                if (strtoupper($value) === 'FALSE') {
                    $value = 0;
                }
            }

            $data[] = $row;
        }

        fclose($handle);

        // 🔥 Générer le CSV temporaire
        $filename = 'converted_' . time() . '.csv';
        $tempPath = storage_path('app/' . $filename);

        $output = fopen($tempPath, 'w');

        foreach ($data as $line) {
            fputcsv($output, $line);
        }

        fclose($output);

        // 🔥 Télécharger automatiquement
        return response()->download($tempPath)->deleteFileAfterSend(true);
    }
}
