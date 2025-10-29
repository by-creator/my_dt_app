<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TelephoneFixe extends Model
{
    protected $fillable = [
        'annuaire',
        'nom',
        'prenom',
        'type',
        'entite',
        'role',
    ];
}
