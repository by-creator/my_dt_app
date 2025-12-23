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
        'zone',
        'chassis',
        'poids',
        'bae',
        'booking',
        'shipping_line',
        'category',
        'type',
        'model',
        'client',
        'chauffeur',
        'permis',
        'pointeur',
        'responsable',
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
