<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ordinateur extends Model
{
    use HasFactory;
    
     protected $fillable = [
        'serie',
        'model',
        'type',
        'utilisateur',
        'service',
        'site',
    ];
}
