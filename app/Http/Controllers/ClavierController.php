<?php

namespace App\Http\Controllers;

use App\Exports\ClavierExport;
use App\Imports\ClavierImport;
use App\Models\Clavier;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ClavierController extends Controller
{
    public function index()
    {
        $claviers = Clavier::orderBy('id', 'desc')->get();
        return view('stock.clavier.index', compact('claviers'));
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

        Clavier::create($data);

        return redirect()->route('clavier.index')->with('create', 'clavier créé avec succès.');
    }

    public function update(Request $request, $id)
    {
        $clavier = Clavier::findOrFail($id);

        $clavier->serie = $request->serie;
        $clavier->model = $request->model;
        $clavier->type = $request->type;
        $clavier->utilisateur = $request->utilisateur;
        $clavier->service = $request->service;
        $clavier->site = $request->site;

        $clavier->save();

        return redirect()->route('clavier.index')->with('update', 'clavier mis à jour avec succès.');
    }

    public function delete($id)
    {
        $user = Clavier::findOrFail($id);
        $user->delete();

        return redirect()->route('clavier.index')->with('delete', 'clavier supprimé avec succès.');
    }

    public function export()
    {
        return Excel::download(new ClavierExport, 'claviers.xlsx');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx',
        ]);

        Excel::import(new ClavierImport, $request->file('file'));

        return redirect()->back()->with('success', 'Importation réussie.');
    }


}
