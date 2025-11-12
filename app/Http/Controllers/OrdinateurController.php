<?php

namespace App\Http\Controllers;

use App\Exports\OrdinateurExport;
use App\Imports\OrdinateurImport;
use App\Models\Ordinateur;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class OrdinateurController extends Controller
{
    public function index()
    {
        $ordinateurs = Ordinateur::orderBy('id', 'desc')->get();
        return view('stock.ordinateur.index', compact('ordinateurs'));
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
            'date_reception' => 'nullable||date',
            'date_deploiement' => 'nullable||date',


        ]);

        Ordinateur::create($data);

        return redirect()->route('ordinateur.index')->with('create', 'Ordinateur créé avec succès.');
    }

    public function update(Request $request, $id)
    {
        $ordinateur = Ordinateur::findOrFail($id);

        $ordinateur->serie = $request->serie;
        $ordinateur->model = $request->model;
        $ordinateur->type = $request->type;
        $ordinateur->utilisateur = $request->utilisateur;
        $ordinateur->service = $request->service;
        $ordinateur->site = $request->site;
        $ordinateur->date_reception = $request->date_reception;
        $ordinateur->date_deploiement = $request->date_deploiement;

        $ordinateur->save();

        return redirect()->route('ordinateur.index')->with('update', 'Ordinateur mis à jour avec succès.');
    }

    public function delete($id)
    {
        $user = Ordinateur::findOrFail($id);
        $user->delete();

        return redirect()->route('ordinateur.index')->with('delete', 'Ordinateur supprimé avec succès.');
    }

    public function export()
    {
        return Excel::download(new OrdinateurExport, 'Ordinateurs.xlsx');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx',
        ]);

        Excel::import(new OrdinateurImport, $request->file('file'));

        return redirect()->back()->with('success', 'Importation réussie.');
    }


}
