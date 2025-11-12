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
            'serie' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'utilisateur' => 'required|string|max:255',
            'service' => 'required|string|max:255',
            'site' => 'required|string|max:255',


        ]);

        Station::create($data);

        return redirect()->route('station.index')->with('create', 'station créé avec succès.');
    }

    public function update(Request $request, $id)
    {
        $station = Station::findOrFail($id);

        $station->serie = $request->serie;
        $station->model = $request->model;
        $station->type = $request->type;
        $station->utilisateur = $request->utilisateur;
        $station->service = $request->service;
        $station->site = $request->site;

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
