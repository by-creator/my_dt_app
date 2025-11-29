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
        $dossiers = DossierFacturation::orderBy('created_at', 'desc')->get();
        return view('dossier_facturation.list               ', compact('dossiers'));
    }

    public function store(Request $request)
    {
        $fields = ['proforma', 'facture', 'bon'];

        $validated = $request->validate([
            'proforma.*' => 'nullable|mimes:pdf|max:2048',
            'facture.*' => 'nullable|mimes:pdf|max:2048',
            'bon.*' => 'nullable|mimes:pdf|max:2048',
            'date_proforma' => 'nullable|date',
        ]);

        $saveData = [
            'date_proforma' => $request->date_proforma,
        ];

        foreach ($fields as $field) {
            $saveData[$field] = [];

            if ($request->hasFile($field)) {
                foreach ($request->file($field) as $file) {
                    $path = $file->store("documents/$field", 'b2'); // B2 disk

                    if ($path) {
                        $saveData[$field][] = [
                            'original' => $file->getClientOriginalName(),
                            'path' => $path,
                        ];
                    }
                }
            }
        }

        DossierFacturation::create($saveData);

        return back()->with('success', 'Documents enregistrés avec succès !');
    }
}
