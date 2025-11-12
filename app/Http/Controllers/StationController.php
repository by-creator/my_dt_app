<?php

namespace App\Http\Controllers;

use App\Exports\StationExport;
use App\Imports\StationImport;
use App\Models\Station;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class StationController extends Controller
{
    public function index()
    {
        $stations = Station::orderBy('id', 'desc')->get();
        return view('stock.station.index', compact('stations'));
    }

    public function create(Request $request)
    {
        $data = $request->validate([
            'date_reception' => 'nullable||date',
            'date_deploiement' => 'nullable||date',
            'service_tag' => 'nullable||string|max:255',
            'marque' => 'nullable||string|max:255',
            'utilisateur' => 'nullable||string|max:255',



        ]);

        Station::create($data);

        return redirect()->route('station.index')->with('create', 'station créé avec succès.');
    }

    public function update(Request $request, $id)
    {
        $station = Station::findOrFail($id);

        $station->date_reception = $request->date_reception;
        $station->date_deploiement = $request->date_deploiement;
        $station->service_tag = $request->service_tag;
        $station->marque = $request->marque;
        $station->utilisateur = $request->utilisateur;

        $station->save();

        return redirect()->route('station.index')->with('update', 'station mis à jour avec succès.');
    }

    public function delete($id)
    {
        $user = Station::findOrFail($id);
        $user->delete();

        return redirect()->route('station.index')->with('delete', 'station supprimé avec succès.');
    }

    public function export()
    {
        return Excel::download(new StationExport, 'stations.xlsx');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx',
        ]);

        Excel::import(new StationImport, $request->file('file'));

        return redirect()->back()->with('success', 'Importation réussie.');
    }


}
