<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Imports\RapportInfosFacturationImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Models\Yard;


class RapportController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('rapport.index', compact('user'));
    }

    public function yard(Request $request)
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


    public function infosFacturationImport(Request $request)
    {
        Log::info('📥 Début import infos facturation');

        $request->validate([
            'facturation_file' => 'required|file|mimes:xlsx,xls,csv',
        ]);

        $file = $request->file('facturation_file');

        // 🔥 IMPORTANT : stream vers B2 (pas load en mémoire)
        $path = 'imports/facturation/' . uniqid() . '-' . $file->getClientOriginalName();

        Storage::disk('b2')->writeStream(
            $path,
            fopen($file->getRealPath(), 'r')
        );

        Log::info('📦 Fichier uploadé sur B2', [
            'path' => $path,
            'size' => $file->getSize(),
        ]);

        // 🚀 IMPORT ASYNC
        Excel::queueImport(
            new RapportInfosFacturationImport,
            $path,
            'b2'
        )->chain([
            new \App\Jobs\ConsolidateInfosFacturationJob($path),
        ]);

        Log::info('🚀 Import RapportInfosFacturation mis en queue', [
            'path' => $path,
        ]);

        return back()->with('success', 'Import lancé en arrière-plan 🚀');
    }
}
