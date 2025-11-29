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
        $fields = ['proforma', 'facture', 'bon'];
        $dataToSave = [];

        foreach ($fields as $field) {

            $filesArray = [];

            if ($request->hasFile($field)) {

                foreach ($request->file($field) as $file) {

                    $originalName = $file->getClientOriginalName();

                    // chemin dans le bucket
                    $path = $file->store("documents/$field", 'b2');

                    $filesArray[] = [
                        'original' => $originalName,
                        'path' => $path,
                    ];
                }
            }

            $dataToSave[$field] = $filesArray;
        }

        DossierFacturation::create($dataToSave);

        return back()->with('success', 'Dossier enregistré avec succès !');
    }
}
