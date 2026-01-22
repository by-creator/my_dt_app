<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\ConvertsDates;


class OrdreApprocheStaging extends Model
{
    use HasFactory, ConvertsDates;

    protected $table = 'ordre_approches_staging';

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
        'date',
        'time',
        'bae',
        'client',
        'chauffeur',
        'permis',
        'pointeur',
        'responsable',
        'reserve',
    ];
}
