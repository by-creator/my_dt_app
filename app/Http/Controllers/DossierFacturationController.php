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
        $data = [];

        foreach (['proforma', 'facture', 'bon'] as $field) {

            $filesArray = [];

            if ($request->hasFile($field)) {
                foreach ($request->file($field) as $file) {

                    $storedPath = $file->store("documents/$field", 'b2');

                    // n'enregistrer QUE si l'upload réussit
                    if ($storedPath && $storedPath !== false) {
                        $filesArray[] = [
                            "original" => $file->getClientOriginalName(),
                            "path" => $storedPath
                        ];
                    }
                }
            }

            $data[$field] = $filesArray;
        }

        DossierFacturation::create($data);

        return back()->with('success', 'Documents enregistrés !');
    }
}
