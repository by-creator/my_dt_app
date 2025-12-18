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
        $dateString = $request->date;
        $date = Carbon::parse($dateString);

        $vesselArrivalDateString = $request->date;
        $vesselArrivalDate = Carbon::parse($vesselArrivalDateString);


        $data = [
            'date' => $date,
            'chassis' => $request->chassis,
            'poids' => $request->poids,
            'lane' => $request->lane,
            'lane_number' => $request->lane_number,
            'bae' => $request->bae,
            'booking' => $request->booking,
            'port' => $request->port,
            'vessel' => $request->vessel,
            'call_number' => $request->call_number,
            'vessel_arrival_date' => $vesselArrivalDate,
            'shipping_line' => $request->shipping_line,
            'category' => $request->category,
            'type' => $request->type,
            'model' => $request->model,
            'client' => $request->client,
            'chauffeur' => $request->chauffeur,
            'permis' => $request->permis,
            'reserve' => $request->reserve,
            'pointeur' => $request->pointeur,
            'responsable' => $request->responsable,

        ];

        //OrdreApproche::create($data);

        return view('ordre_approche.fiche', compact('data'))->with('create', 'Ordre créé avec succès.');
            
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
