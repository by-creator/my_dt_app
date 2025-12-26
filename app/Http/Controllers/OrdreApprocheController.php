<?php

namespace App\Http\Controllers;

use App\Models\OrdreApproche;
use Carbon\Carbon;
use Illuminate\Http\Request;

class OrdreApprocheController extends Controller
{

    public function index(Request $request)
    {
        $ordres = OrdreApproche::orderBy('id', 'desc')->get();
        return view('ordre_approche.index', compact('ordres'));
    }

    public function list(Request $request)
    {
        $request->validate([
            'ordre_id' => 'required|string'
        ]);

        // 🔍 Récupération de l'ordre
        $ordre = OrdreApproche::where('ItemNumber', $request->ordre_id)->first();

        return view('ordre_approche.list', compact('ordre'));
    }



    public function create(Request $request)
    {
        $date = Carbon::now();
        $time = Carbon::now();

        $data = [
            'date' => $date,
            'ItemNumber' => $request->ItemNumber,
            'Zone' => $request->Zone,
            'TypeDeMarchandise' => $request->TypeDeMarchandise,
            'bae' => $request->bae,
            'BlNumber' => $request->BlNumber,
            'Vessel' => $request->Vessel,
            'callNumber' => $request->callNumber,
            'vesselarrivaldate' => $request->vesselarrivaldate,
            'Shipowner' => $request->Shipowner,
            'Item_Code' => $request->Item_Code,
            'Item_Type' => $request->Item_Type,
            'Description_' => $request->Description_,
            'client' => $request->client,
            'chauffeur' => $request->chauffeur,
            'permis' => $request->permis,
            'pointeur' => $request->pointeur,
            'responsable' => $request->responsable,
            'reserve' => $request->reserve,

        ];

        //OrdreApproche::create($data);

        return view('ordre_approche.fiche', compact('data'))->with('create', 'Ordre créé avec succès.');
    }

    public function update(Request $request, $id)
    {
        $ordre = OrdreApproche::findOrFail($id);

        $ordre->date = Carbon::now();
        $ordre->time = Carbon::now();
        $ordre->bae = $request->bae;
        $ordre->reserve = $request->reserve;
        $ordre->client = $request->client;
        $ordre->chauffeur = $request->chauffeur;
        $ordre->permis = $request->permis;
        $ordre->pointeur = $request->pointeur;
        $ordre->responsable = $request->responsable;

        $data = [
            'date' => Carbon::now(),
            'time' => Carbon::now(),
            'ItemNumber' => $request->ItemNumber,
            'Zone' => $request->Zone,
            'TypeDeMarchandise' => $request->TypeDeMarchandise,
            'bae' => $request->bae,
            'BlNumber' => $request->BlNumber,
            'Vessel' => $request->Vessel,
            'callNumber' => $request->callNumber,
            'vesselarrivaldate' => $request->vesselarrivaldate,
            'Shipowner' => $request->Shipowner,
            'Item_Code' => $request->Item_Code,
            'Item_Type' => $request->Item_Type,
            'Description_' => $request->Description_,
            'bae' => $request->bae,
            'client' => $request->client,
            'chauffeur' => $request->chauffeur,
            'permis' => $request->permis,
            'pointeur' => $request->pointeur,
            'responsable' => $request->responsable,
            'reserve' => $request->reserve,

        ];

        $ordre->save();

        return view('ordre_approche.fiche', compact('data'))->with('update', 'Ordre modifié avec succès.');
    }

    public function delete($id)
    {
        $ordre = OrdreApproche::findOrFail($id);
        $ordre->delete();

        return redirect()->route('ordre_approche.index')->with('delete', 'Ordre supprimé avec succès.');
    }
}
