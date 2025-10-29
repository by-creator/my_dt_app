<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ordinateur extends Model
{
     protected $fillable = [
        'serie',
        'model',
        'type',
        'utilisateur',
        'service',
        'site',
    ];
}
