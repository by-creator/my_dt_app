<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\PosteFixesImport;
use App\Exports\PosteFixesExport;
use App\Models\PosteFixe;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class PosteFixeController extends Controller
{
    public function index()
    {
        $poste_fixes = PosteFixe::orderBy('id', 'desc')->get();
        $user = Auth::user();
        return view('poste_fixes.index', compact('poste_fixes', 'user'));
    }

    public function create(Request $request)
    {
        $data = $request->validate([
            'annuaire' => 'nullable|string|max:255',
            'nom'      => 'nullable|string|max:255',
            'prenom'   => 'nullable|string|max:255',
            'type'     => 'nullable|string|max:255',
            'entite'   => 'nullable|string|max:255',
            'role'     => 'nullable|string|max:255',
        ]);

        PosteFixe::create($data);

        return redirect()->back()->with('create', 'Poste fixe créé avec succès.');
    }

    public function update(Request $request, $id)
    {
        $poste = PosteFixe::findOrFail($id);

        $poste->annuaire = $request->annuaire;
        $poste->nom      = $request->nom;
        $poste->prenom   = $request->prenom;
        $poste->type     = $request->type;
        $poste->entite   = $request->entite;
        $poste->role     = $request->role;

        $poste->save();

        return redirect()->back()->with('update', 'Poste fixe mis à jour avec succès.');
    }

    public function delete($id)
    {
        $poste = PosteFixe::findOrFail($id);
        $poste->delete();

        return redirect()->back()->with('delete', 'Poste fixe supprimé avec succès.');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,xlsx,txt',
        ]);

        Excel::import(new PosteFixesImport, $request->file('file'));

        return redirect()->back()->with('success', 'Postes fixes importés avec succès.');
    }

    public function export()
    {
        $fileName = 'poste_fixes_' . now()->format('Ymd_His') . '.csv';
        return Excel::download(new PosteFixesExport, $fileName);
    }
}
