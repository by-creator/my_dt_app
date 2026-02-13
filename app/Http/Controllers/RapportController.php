<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Imports\RapportInfosFacturationImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;



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
