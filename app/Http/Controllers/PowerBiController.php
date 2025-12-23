<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;


class PowerBiController extends Controller
{
    public function fetch(Request $request)
    {
        $response = Http::post(env('POWER_AUTOMATE_URL'), [
            'item_number' => $request->item_number
        ]);

        $data = $response->json();

        return view('powerbi.form', [
            'zone' => $data['Zone'] ?? '',
            'chassis' => $data['ItemNumber'] ?? '',
            'poids' => $data['TypeDeMarchandise'] ?? '',
            'booking' => $data['BlNumber'] ?? '',
            'shipping_line' => $data['Shipowner'] ?? '',
            'category' => $data['Item_Code'] ?? '',
            'type' => $data['Item_Type'] ?? '',
            'model'        => $data['Description_'] ?? ''
        ]);
    }
}
