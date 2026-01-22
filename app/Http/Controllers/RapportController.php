<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Imports\RapportInfosFacturationImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Log;

class RapportController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('rapport.index', compact('user'));
    }


    public function infosFacturationImport(Request $request)
    {
        Log::info('📥 Début import infos facturation');

        Log::info('📌 Avant validation', [
            'has_file' => $request->hasFile('facturation_file'),
            'all' => $request->except('facturation_file'),
        ]);

        $request->validate([
            'facturation_file' => 'required|file|mimes:xlsx,xls,csv'
        ]);

        Log::info('✅ Validation OK');

        $file = $request->file('facturation_file');

        $path = $file->store('imports/facturation', 'local');


       Log::info('📦 Fichier stocké', [
            'path' => $path,
            'size' => $file->getSize(),
        ]);

        Excel::queueImport(
            new RapportInfosFacturationImport,
            $path,
            'local'
        )->chain([
            new \App\Jobs\ConsolidateInfosFacturationJob($path),
        ]);

         Log::info('🚀 Import Infos Facturation mis en queue', [
            'path' => $path,
        ]);

        return back()->with('success', 'Import lancé avec succès');
    }
}
