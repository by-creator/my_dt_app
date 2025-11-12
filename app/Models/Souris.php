<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Souris extends Model
{
    use HasFactory;

    protected $fillable = [
        'date_reception',
        'date_deploiement',
        'marque',
        'utilisateur',
    ];
}
