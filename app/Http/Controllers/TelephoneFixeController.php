<?php

namespace App\Http\Controllers;

use App\Exports\TelephoneFixesExport;
use App\Imports\TelephoneFixesImport;
use App\Models\TelephoneFixe;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class TelephoneFixeController extends Controller
{
    public function index()
    {
        $fixes = TelephoneFixe::orderBy('id', 'desc')->get();
        return view('stock.telephone.index', compact('fixes'));
    }

    public function create(Request $request)
    {
        $data = $request->validate([
            'annuaire' => 'required|string|max:255',
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'entite' => 'required|string|max:255',
            'role' => 'required|string|max:255',
            'date_reception' => 'nullable||date',
            'date_deploiement' => 'nullable||date',

        ]);

        TelephoneFixe::create($data);

        return redirect()->route('telephone-fixe.index')->with('create', 'Téléphone créé avec succès.');
    }

    public function update(Request $request, $id)
    {
        $fixe = TelephoneFixe::findOrFail($id);

        $fixe->annuaire = $request->annuaire;
        $fixe->nom = $request->nom;
        $fixe->prenom = $request->prenom;
        $fixe->type = $request->type;
        $fixe->entite = $request->entite;
        $fixe->role = $request->role;
        $fixe->date_reception = $request->date_reception;
        $fixe->date_deploiement = $request->date_deploiement;
        
        $fixe->save();

        return redirect()->route('telephone-fixe.index')->with('update', 'Téléphone mis à jour avec succès.');
    }

    public function delete($id)
    {
        $user = TelephoneFixe::findOrFail($id);
        $user->delete();

        return redirect()->route('telephone-fixe.index')->with('delete', 'Téléphone supprimé avec succès.');
    }

    public function export()
    {
        return Excel::download(new TelephoneFixesExport, 'telephone_fixes.xlsx');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx',
        ]);

        Excel::import(new TelephoneFixesImport, $request->file('file'));

        return redirect()->back()->with('success', 'Importation réussie.');
    }

    public function tutorial()
    {
        return view('pages.back.informatique.telephone.fixe.tutoriel');
    }

}
