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

    public function show($id)
    {
        $dossier = DossierFacturation::findOrFail($id);

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
            'proforma' => 'nullable|mimes:pdf|max:2048',
            'facture' => 'nullable|mimes:pdf|max:2048',
            'bon' => 'nullable|mimes:pdf|max:2048',
        ]);


        foreach (['proforma', 'facture', 'bon'] as $field) {
            if ($request->hasFile($field)) {

                // nom original
                $saveData[$field . '_original_name'] = $request->file($field)->getClientOriginalName();

                // upload du fichier
                //$saveData[$field] = $request->file($field)->store("documents/$field", 'public');
                $saveData[$field] = $request->file($field)->store("documents/$field", 'b2');

            }
        }

        DossierFacturation::create($saveData);

        return back()->with('success', 'Documents enregistrés avec noms d\'origine !');
    }
}
