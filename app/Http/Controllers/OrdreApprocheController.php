<?php

namespace App\Http\Controllers;

use App\Jobs\ImportOrdreApprocheCsvJob;
use App\Models\OrdreApproche;
use App\Models\Yard;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;


class OrdreApprocheController extends Controller
{

     public function index(Request $request)
    {
        $user = Auth::user();

        $filters = ['item_number'];

        $query = Yard::query();

        foreach ($filters as $field) {
            if ($request->filled($field)) {
                $query->where($field, $request->$field);
            }
        }

        $yards = $query
            ->latest()
            ->paginate(3)
            ->withQueryString();

        return view('ordre_approche.index', compact('yards', 'user'));
    }

    public function datalist(Request $request)
    {
        $field = $request->get('field'); 
        $query = $request->get('q');

        // 🔐 Sécurité : champs autorisés
        if (!in_array($field, ['item_number' ])) {
            return response()->json([]);
        }

        $results = Yard::query()
            ->whereNotNull($field)
            ->when(
                $query,
                fn($q) =>
                $q->where($field, 'LIKE', "%{$query}%")
            )
            ->distinct()
            ->limit(10) // ⚡ limite pour perf
            ->pluck($field);

        return response()->json($results);
    }

    public function list(Request $request)
    {
        $request->validate([
            'item_number' => 'required|string'
        ]);

        // 🔍 Récupération de l'ordre
        $ordre = Yard::where('item_number', $request->item_number)->first();

        $user = Auth::user();

        return view('ordre_approche.list', compact('ordre','user'));
    }





    public function update(Request $request, $id)
    {
        $ordre = Yard::findOrFail($id);

        Log::info('UPDATE Yard - données reçues', $request->all());

        $ordre->date = Carbon::now();
        $ordre->time = Carbon::now();
        $ordre->reserve = $request->reserve;
        $ordre->chauffeur = $request->chauffeur;
        $ordre->permis = $request->permis;
        $ordre->pointeur = $request->pointeur;
        $ordre->responsable = $request->responsable;

        $data = [
            'date' => Carbon::now(),
            'time' => Carbon::now(),
            'terminal' => $request->terminal,
            'shipowner' => $request->shipowner,
            'item_number' => $request->item_number,
            'item_type' => $request->item_type,
            'item_code' => $request->item_code,
            'bl_number' => $request->bl_number,
            'final_destination_counrty' => $request->final_destination_counrty,
            'description' => $request->description,
            'teu' => $request->teu,
            'volume' => $request->volume,
            'weight' => $request->weight,
            'yard_zone_type' => $request->yard_zone_type,
            'zone' => $request->zone,
            'type_veh' => $request->type_veh,
            'type_de_marchandise' => $request->type_de_marchandise,
            'pod' => $request->pod,
            'yard_zone' => $request->yard_zone,
            'consignee' => $request->consignee,
            'call_number' => $request->call_number,
            'vessel' => $request->vessel,
            'eta' => $request->eta,
            'vessel_arrival_date' => $request->vessel_arrival_date,
            'cycle' => $request->cycle,
            'yard_quantity' => $request->yard_quantity,
            'days_since_in' => $request->days_since_in,
            'dwelltime' => $request->dwelltime,
            'bae' => $request->bae,
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
