<?php

namespace App\Http\Controllers;

use App\Models\OrdreApproche;
use Carbon\Carbon;
use Illuminate\Http\Request;

class OrdreApprocheController extends Controller
{

    public function index()
    {
        $ordres = OrdreApproche::orderBy('id', 'desc')->get();
        return view('ordre_approche.index', compact('ordres'));
    }

   
    public function create(Request $request)
    {
        $data = $request->validate([
            'numero' => 'required|string|max:255',
            'date' => 'nullable||string',

        ]);

        OrdreApproche::create($data);

        return redirect()->route('ordre_approche.index')
            ->with('create', 'Ordre créé avec succès.');
    }

    public function update(Request $request, $id)
    {
        $ordre = OrdreApproche::findOrFail($id);

        $ordre->numero = $request->numero;
        $ordre->date = $request->date;

        $ordre->save();

        return redirect()->route('ordre_approche.index')->with('update', 'Ordre mis à jour avec succès.');
    }

    public function delete($id)
    {
        $ordre = OrdreApproche::findOrFail($id);
        $ordre->delete();

        return redirect()->route('ordre_approche.index')->with('delete', 'Ordre supprimé avec succès.');
    }
}
