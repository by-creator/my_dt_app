<?php

namespace App\Http\Controllers;

use App\Models\DossierFacturation;
use Illuminate\Http\Request;

class DossierFacturationController extends Controller
{

    public function index()
    {
        return view('dossier_facturation.form');
    }

    public function show(DossierFacturation $dossier)
    {
        return view('dossier_facturation.show', compact('dossier'));
    }


    public function list()
    {
        $dossiers = DossierFacturation::all();
        return view('dossier_facturation.list', compact('dossiers'));
    }

    public function store(Request $request)
    {
        $saveData = $request->validate([
            'proforma.*' => 'nullable|mimes:pdf|max:2048',
            'facture.*'  => 'nullable|mimes:pdf|max:2048',
            'bon.*'      => 'nullable|mimes:pdf|max:2048',
        ]);

        $data = [];

        foreach (['proforma', 'facture', 'bon'] as $field) {
            $filesArray = [];

            if ($request->hasFile($field)) {
                foreach ($request->file($field) as $file) {
                    $filesArray[] = [
                        'original' => $file->getClientOriginalName(),
                        'path' => $file->store("documents/$field", 'b2')
                    ];
                }
            }

            $data[$field] = $filesArray;
        }

        DossierFacturation::create($data);

        return back()->with('success', 'Documents enregistrés !');
    }
}
