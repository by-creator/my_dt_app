<?php

namespace App\Http\Controllers;

use App\Models\OrdreApproche;
use Carbon\Carbon;
use Illuminate\Http\Request;

class OrdreApprocheController extends Controller
{

    public function index()
    {
        return view('ordre_approche.index');
    }

    public function vehicule()
    {
        $ordres = OrdreApproche::where('type', 'VEHICULE')
            ->orderBy('id', 'desc')
            ->get();

        return view('ordre_approche.vehicule', compact('ordres'));
    }

    public function conteneur()
    {
        $ordres = OrdreApproche::where('type', 'CONTENEUR')
            ->orderBy('id', 'desc')
            ->get();

        return view('ordre_approche.conteneur', compact('ordres'));
    }

    public function gk()
    {
        $ordres = OrdreApproche::where('type', 'GK')
            ->orderBy('id', 'desc')
            ->get();

        return view('ordre_approche.gk', compact('ordres'));
    }

    public function create(Request $request)
    {
        $data = $request->validate([
            'numero' => 'required|string|max:255',
            'client' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'date' => 'nullable||string',

        ]);

        OrdreApproche::create($data);

        return redirect()->route('ordre_approche.index')->with('create', 'Ordre créé avec succès.');
    }

    public function update(Request $request, $id)
    {
        $ordre = OrdreApproche::findOrFail($id);

        $ordre->numero = $request->numero;
        $ordre->client = $request->client;
        $ordre->type = $request->type;
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
