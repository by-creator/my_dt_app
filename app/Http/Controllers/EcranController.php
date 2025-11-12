<?php

namespace App\Http\Controllers;

use App\Exports\EcranExport;
use App\Imports\EcranImport;
use App\Models\Ecran;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class EcranController extends Controller
{
    public function index()
    {
        $ecrans = Ecran::orderBy('id', 'desc')->get();
        return view('stock.ecran.index', compact('ecrans'));
    }

    public function create(Request $request)
    {
        $data = $request->validate([
            'date_reception' => 'nullable||date',
            'date_deploiement' => 'nullable||date',
            'service_tag' => 'nullable||string|max:255',
            'etiquetage' => 'nullable||string|max:255',
            'service' => 'nullable||string|max:255',
            'utilisateur' => 'nullable||string|max:255',


        ]);

        Ecran::create($data);

        return redirect()->route('ecran.index')->with('create', 'ecran créé avec succès.');
    }

    public function update(Request $request, $id)
    {
        $ecran = Ecran::findOrFail($id);

        $ecran->date_reception = $request->date_reception;
        $ecran->date_deploiement = $request->date_deploiement;
        $ecran->service_tag = $request->service_tag;
        $ecran->etiquetage = $request->etiquetage;
        $ecran->service = $request->service;
        $ecran->utilisateur = $request->utilisateur;

        $ecran->save();

        return redirect()->route('ecran.index')->with('update', 'ecran mis à jour avec succès.');
    }

    public function delete($id)
    {
        $user = Ecran::findOrFail($id);
        $user->delete();

        return redirect()->route('ecran.index')->with('delete', 'ecran supprimé avec succès.');
    }

    public function export()
    {
        return Excel::download(new EcranExport, 'ecrans.xlsx');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx',
        ]);

        Excel::import(new EcranImport, $request->file('file'));

        return redirect()->back()->with('success', 'Importation réussie.');
    }


}
