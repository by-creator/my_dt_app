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

        $request->validate([
            'facturation_file' => 'required|file|mimes:xlsx,xls,csv',
        ]);

        $file = $request->file('facturation_file');

        // ✅ stockage direct sur B2
        $path = $file->store('imports/facturation', 'b2');

        Log::info('📦 Fichier stocké sur B2', [
            'path' => $path,
            'size' => $file->getSize(),
        ]);

        // 🚀 IMPORT ASYNC (worker)
        Excel::queueImport(
            new RapportInfosFacturationImport,
            $path,
            'b2'
        )->chain([
            new \App\Jobs\ConsolidateInfosFacturationJob($path),
        ]);

        return back()->with('success', 'Import lancé en arrière-plan');
    }
}
