<?php

namespace App\Http\Controllers;

use App\Exports\SourisExport;
use App\Imports\SourisImport;
use App\Models\Souris;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class SourisControlller extends Controller
{
    public function index()
    {
        $souriss = Souris::orderBy('id', 'desc')->get();
        return view('stock.souris.index', compact('souriss'));
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

        Souris::create($data);

        return redirect()->route('souris.index')->with('create', 'souris créé avec succès.');
    }

    public function update(Request $request, $id)
    {
        $souris = Souris::findOrFail($id);

        $souris->serie = $request->serie;
        $souris->model = $request->model;
        $souris->type = $request->type;
        $souris->utilisateur = $request->utilisateur;
        $souris->service = $request->service;
        $souris->site = $request->site;

        $souris->save();

        return redirect()->route('souris.index')->with('update', 'souris mis à jour avec succès.');
    }

    public function delete($id)
    {
        $user = Souris::findOrFail($id);
        $user->delete();

        return redirect()->route('souris.index')->with('delete', 'souris supprimé avec succès.');
    }

    public function export()
    {
        return Excel::download(new SourisExport, 'souriss.xlsx');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx',
        ]);

        Excel::import(new SourisImport, $request->file('file'));

        return redirect()->back()->with('success', 'Importation réussie.');
    }


}
