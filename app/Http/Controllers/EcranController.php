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
            'serie' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'utilisateur' => 'required|string|max:255',
            'service' => 'required|string|max:255',
            'site' => 'required|string|max:255',


        ]);

        Ecran::create($data);

        return redirect()->route('ecran.index')->with('create', 'ecran créé avec succès.');
    }

    public function update(Request $request, $id)
    {
        $ecran = Ecran::findOrFail($id);

        $ecran->serie = $request->serie;
        $ecran->model = $request->model;
        $ecran->type = $request->type;
        $ecran->utilisateur = $request->utilisateur;
        $ecran->service = $request->service;
        $ecran->site = $request->site;

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
