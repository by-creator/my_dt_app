<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OrdreApproche;


class PowerBiController extends Controller
{
    /*
    public function fetch(Request $request)
    {
        $response = Http::post('https://site-dt-staging-4682ed3f9fbf.herokuapp.com/api/powerbi/fetch', [
            'item_number' => $request->item_number
        ]);

        $data = $response->json();

        return view('powerbi.form', [
            'zone' => $data['Zone'] ?? '',
            'chassis' => $data['ItemNumber'] ?? '',
            'poids' => $data['TypeDeMarchandise'] ?? '',
            'booking' => $data['BlNumber'] ?? '',
            'vessel' => $data['Vessel'] ?? '',
            'call_number' => $data['callNumber'] ?? '',
            'vessel_arrival_date' => $data['vesselarrivaldate'] ?? '',
            'shipping_line' => $data['Shipowner'] ?? '',
            'category' => $data['Item_Code'] ?? '',
            'type' => $data['Item_Type'] ?? '',
            'model'        => $data['Description_'] ?? ''
        ]);
    }*/

    public function fetch(Request $request)
    {
        $request->validate([
            'chassis' => 'required|string',
            'zone' => 'nullable|string',
            'poids' => 'nullable|string',
            'booking' => 'nullable|string',
            'vessel' => 'nullable|string',
            'call_number' => 'nullable|string',
            'vessel_arrival_date' => 'nullable|string',
            'shipping_line' => 'nullable|string',
            'category' => 'nullable|string',
            'type' => 'nullable|string',
            'model' => 'nullable|string',
        ]);

        OrdreApproche::updateOrCreate(
            ['chassis' => $request->chassis],
            [
                'zone' => $request->zone,
                'poids' => $request->poids,
                'booking' => $request->booking,
                'vessel' => $request->vessel,
                'call_number' => $request->call_number,
                'vessel_arrival_date' => $request->vessel_arrival_date,
                'shipping_line' => $request->shipping_line,
                'category' => $request->category,
                'type' => $request->type,
                'model' => $request->model,
            ]
        );


        return response()->json([
            'status' => 'ok'
        ]);
    }
}

/**
 * 
 * curl -X POST http://localhost:8000/api/powerbi/fetch \
-H "Content-Type: application/json" \
-d '{
  "chassis": "12345",
  "zone" : "zone",
                "poids" : "poids",
                "booking" : "booking",
                "shipping_line" : "shipping_line",
                "category" : "category",
                "type" : "type",
                "model" : "model",
}'

 */
