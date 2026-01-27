<?php

namespace App\Http\Controllers;

use App\Jobs\ImportOrdreApprocheCsvJob;
use App\Models\OrdreApproche;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;


class OrdreApprocheController extends Controller
{

    public function index(Request $request)
    {
        $ordres = OrdreApproche::orderBy('id', 'desc')->get();
        $user = Auth::user();
        return view('ordre_approche.index', compact('ordres', 'user'));
    }

    public function list(Request $request)
    {
        $request->validate([
            'ordre_id' => 'required|string'
        ]);

        // 🔍 Récupération de l'ordre
        $ordre = OrdreApproche::where('ItemNumber', $request->ordre_id)->first();
        $user = Auth::user();

        return view('ordre_approche.list', compact('ordre', 'user'));
    }





    public function update(Request $request, $id)
    {
        $ordre = OrdreApproche::findOrFail($id);

        Log::info('UPDATE OrdreApproche - données reçues', $request->all());

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
            'Terminal' => $request->Terminal,
            'Shipowner' => $request->Shipowner,
            'ItemNumber' => $request->ItemNumber,
            'Item_Type' => $request->Item_Type,
            'Item_Code' => $request->Item_Code,
            'BlNumber' => $request->BlNumber,
            'FinalDestinationCountry' => $request->FinalDestinationCountry,
            'Description_' => $request->Description_,
            'TEU' => $request->TEU,
            'Volume' => $request->Volume,
            'Weight_' => $request->Weight_,
            'YardZoneType' => $request->YardZoneType,
            'Zone' => $request->Zone,
            'Type_Veh' => $request->Type_Veh,
            'TypeDeMarchandise' => $request->TypeDeMarchandise,
            'POD' => $request->POD,
            'YardZone' => $request->YardZone,
            'consignee' => $request->consignee,
            'callNumber' => $request->callNumber,
            'Vessel' => $request->Vessel,
            'ETA' => $request->ETA,
            'vesselarrivaldate' => $request->vesselarrivaldate,
            'Cycle' => $request->Cycle,
            'Yard Quantity' => $request->YardQuantity,
            'DAYS SINCE IN' => $request->DaysSinceIn,
            'Dwelltime' => $request->Dwelltime,
            'bae' => $request->bae,
            'client' => $request->client,
            'chauffeur' => $request->chauffeur,
            'permis' => $request->permis,
            'pointeur' => $request->pointeur,
            'responsable' => $request->responsable,
            'reserve' => $request->reserve

        ];

        $ordre->save();

        return view('ordre_approche.fiche', compact('data'))->with('update', 'Ordre modifié avec succès.');
    }

    //return view('ordre_approche.fiche', compact('data'))->with('update', 'Ordre modifié avec succès.');



    public function import(Request $request)
    {
        $request->validate([
            'ordre_approche_file' => 'required|file|mimes:csv,txt',
        ]);

        $file = $request->file('ordre_approche_file');

        // 1️⃣ Upload B2
        $b2Path = 'imports/ordre_approche/' . uniqid() . '.csv';
        Storage::disk('b2')->writeStream(
            $b2Path,
            fopen($file->getRealPath(), 'r')
        );

        // 2️⃣ Créer dossier local
        $localDir = storage_path('app/imports/tmp');
        if (!is_dir($localDir)) {
            mkdir($localDir, 0755, true);
        }

        // 3️⃣ Copier en local
        $localPath = 'imports/tmp/' . uniqid() . '.csv';
        Storage::disk('local')->put(
            $localPath,
            Storage::disk('b2')->get($b2Path)
        );

        // 4️⃣ Lancer le job CSV natif
        ImportOrdreApprocheCsvJob::dispatch(
            $localPath,
            $b2Path
        );

        return back()->with('success', 'Import CSV lancé');
    }
}
