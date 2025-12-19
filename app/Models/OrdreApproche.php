<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\ConvertsDates;


class OrdreApproche extends Model
{
    use HasFactory, ConvertsDates;

    protected $fillable = [
        'date',
        'time',
        'chassis',
        'poids',
        'lane',
        'lane_number',
        'bae',
        'booking',
        'port',
        'vessel',
        'call_number',
        'vessel_arrival_date',
        'vessel_arrival_time',
        'shipping_line',
        'category',
        'type',
        'model',
        'client',
        'chauffeur',
        'permis',
        'reserve',
        'pointeur',
        'responsable',
    ];
}
