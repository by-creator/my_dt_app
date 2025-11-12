<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\ConvertsDates;


class TelephoneFixe extends Model
{
    use HasFactory, ConvertsDates;
    
    protected $fillable = [
        'annuaire',
        'nom',
        'prenom',
        'type',
        'entite',
        'role',
        'date_reception',
        'date_deploiement'
    ];

    protected $casts = ['date_reception' => 'datetime', 'date_deploiement' => 'datetime'];

    public function getDateReceptionFormattedAttribute()
    {
        return $this->date_reception ? $this->date_reception->format('d/m/Y H:i') : null;
    }

    public function getDateDeploiementFormattedAttribute()
    {
        return $this->date_deploiement ? $this->date_deploiement->format('d/m/Y H:i') : null;
    }
}
