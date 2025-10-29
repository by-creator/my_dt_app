<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TelephoneFixe extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'annuaire',
        'nom',
        'prenom',
        'type',
        'entite',
        'role',
    ];
}
