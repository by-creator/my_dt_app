<?php

namespace App\Http\Controllers;

use App\Jobs\ImportOrdreApprocheCsvJob;
use App\Models\OrdreApproche;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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
        $ordre = OrdreApproche::where('item_number', $request->ordre_id)->first();
        $user = Auth::user();

        return view('ordre_approche.list', compact('ordre', 'user'));
    }



    public function create(Request $request)
    {
        $date = Carbon::now();
        $time = Carbon::now();

        $data = [
            'date' => $date,
            'item_number' => $request->ItemNumber,
            'zone' => $request->Zone,
            'type_de_marchandise' => $request->TypeDeMarchandise,
            'bae' => $request->bae,
            'bl_number' => $request->BlNumber,
            'vessel' => $request->Vessel,
            'call_number' => $request->callNumber,
            'vessel_arrival_date' => $request->vesselarrivaldate,
            'shipowner' => $request->Shipowner,
            'item_code' => $request->Item_Code,
            'item_type' => $request->Item_Type,
            'description' => $request->Description_,
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
            'item_number' => $request->ItemNumber,
            'zone' => $request->Zone,
            'type_de_marchandise' => $request->TypeDeMarchandise,
            'bae' => $request->bae,
            'bl_number' => $request->BlNumber,
            'vessel' => $request->Vessel,
            'call_number' => $request->callNumber,
            'vessel_arrival_date' => $request->vesselarrivaldate,
            'shipowner' => $request->Shipowner,
            'item_code' => $request->Item_Code,
            'item_type' => $request->Item_Type,
            'description' => $request->Description_,
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
