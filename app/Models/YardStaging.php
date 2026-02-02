<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class YardStaging extends Model
{
    protected $table = 'yard_stagings';

    protected $fillable = [
        'Terminal',
        'Shipowner',
        'ItemNumber',
        'Item_Type',
        'Item_Code',
        'BlNumber',
        'FinalDestinationCountry',
        'Description_',
        'TEU',
        'Volume',
        'Weight_',
        'YardZoneType',
        'Zone',
        'Type_Veh',
        'TypeDeMarchandise',
        'POD',
        'YardZone',
        'consignee',
        'callNumber',
        'Vessel',
        'ETA',
        'vesselarrivaldate',
        'Cycle',
        'Yard Quantity',
        'DAYS SINCE IN',
        'Dwelltime',
        'Bloqué',
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
