<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ecran extends Model
{
    use HasFactory;

    protected $fillable = [
        'date_reception',
        'date_deploiement',
        'service_tag',
        'etiquetage',
        'service',
        'utilisateur',
    ];
}
