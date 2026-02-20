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

        $yards = $this->getYards($request); // requête normale
        $yard_list = $this->getYardsWithTime($request); // requête avec time not null

        return view('ordre_approche.index', compact('yards', 'yard_list', 'user'));
    }

    private function getYards(Request $request)
    {
        $filters = ['item_number'];

        $query = Yard::query();

        foreach ($filters as $field) {
            if ($request->filled($field)) {
                $query->where($field, $request->$field);
            }
        }

        return $query
            ->latest()
            ->paginate(3)
            ->withQueryString();
    }

    private function getYardsWithTime(Request $request)
    {
        $filters = ['item_number'];

        $query_list = Yard::query()
            ->whereNotNull('time');

        foreach ($filters as $field) {
            if ($request->filled($field)) {
                $query_list->where($field, $request->$field);
            }
        }

        return $query_list
            ->latest()
            ->paginate(3)
            ->withQueryString();
    }

    public function datalist(Request $request)
    {
        $field = $request->get('field');
        $query = $request->get('q');

        // 🔐 Sécurité : champs autorisés
        if (!in_array($field, ['item_number'])) {
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

        return view('ordre_approche.list', compact('ordre', 'user'));
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
            'date' => Carbon::now()->format('d-m-Y'),
            'time' => Carbon::now()->format('H:i'),
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

        $action = $request->input('submit');

        switch ($action) {
            case 'vehicule':
                $titre = "ORDRE D'APPROCHE VEHICULE";
                break;
            case 'tc':
                $titre = "ORDRE DE CHARGEMENT TC";
                break;
            case 'bulk':
                $titre = "ORDRE DE CHARGEMENT BULK";
                break;
            default:
                $titre = "Ordre";
        }

        return view('ordre_approche.fiche', compact('data', 'titre'))
            ->with('update', 'Ordre modifié avec succès.');




        return view('ordre_approche.fiche', compact('data', 'titre'))->with('update', 'Ordre modifié avec succès.');
    }

    public function printOrdre(Yard $yard, $type)
    {
        switch ($type) {
            case 'vehicule':
                $titre = "ORDRE D'APPROCHE VEHICULE";
                break;
            case 'tc':
                $titre = "ORDRE DE CHARGEMENT TC";
                break;
            case 'bulk':
                $titre = "ORDRE DE CHARGEMENT BULK";
                break;
            default:
                abort(404); // sécurité
        }

        $data = [
            'date' => Carbon::parse($yard->date)->format('d-m-Y'),
            'time' => Carbon::parse($yard->time)->format('H:i'),
            'zone' => $yard->zone,
            'item_type' => $yard->item_type,
            'item_number' => $yard->item_number,
            'type_de_marchandise' => $yard->type_de_marchandise,
            'bae' => $yard->bae,
            'bl_number' => $yard->bl_number,
            'vessel' => $yard->vessel,
            'call_number' => $yard->call_number,
            'vessel_arrival_date' => Carbon::parse($yard->vessel_arrival_date)->format('d-m-Y'),
            'shipowner' => $yard->shipowner,
            'item_code' => $yard->item_code,
            'description' => $yard->description,
            'consignee' => $yard->consignee,
            'chauffeur' => $yard->chauffeur,
            'permis' => $yard->permis,
            'reserve' => $yard->reserve,
            'pointeur' => $yard->pointeur,
            'responsable' => $yard->responsable,
        ];

        return view('ordre_approche.fiche', compact('data', 'titre'))->with('update', 'Ordre imprimé avec succès.');
    }
}
