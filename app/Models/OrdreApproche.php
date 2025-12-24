<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\ConvertsDates;


class OrdreApproche extends Model
{
    use HasFactory, ConvertsDates;

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

        'date',
        'time',
    ];

    protected static function booted()
    {
        static::creating(function ($model) {
            if ($model->created_at && empty($model->date)) {
                $model->date = $model->created_at;
            }
            if ($model->created_at && empty($model->time)) {
                $model->time = $model->created_at;
            }

            if ($model->vessel_arrival_date && empty($model->vessel_arrival_time)) {
                $model->vessel_arrival_time = $model->vessel_arrival_date;
            }
        });
    }
}
