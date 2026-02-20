<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Yard extends Model
{
    protected $table = 'yards';

    protected $fillable = [
        'terminal',
        'shipowner',
        'item_number',
        'item_type',
        'item_code',
        'bl_number',
        'final_destination_country',
        'description',
        'teu',
        'volume',
        'weight',
        'yard_zone_type',
        'zone',
        'type_veh',
        'type_de_marchandise',
        'pod',
        'yard_zone',
        'consignee',
        'call_number',
        'vessel',
        'eta',
        'vessel_arrival_date',
        'cycle',
        'yard_quantity',
        'days_since_in',
        'dwelltime',
        'bloque',
        'date',
        'time',
        'bae',
        'chauffeur',
        'permis',
        'pointeur',
        'responsable',
        'reserve',
    ];

    protected $casts = [
    'vessel_arrival_date' => 'date',
    'eta' => 'date',
    'date' => 'date',
];

}
