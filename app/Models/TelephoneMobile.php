<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TelephoneMobile extends Model
{
    use HasFactory;

    protected $table = 'telephone_mobiles';

    protected $fillable = [
        'matricule',
        'nom',
        'prenom',
        'service',
        'destination',
        'modele_telephone',
        'reference_telephone',
        'montant_ancien_forfait_ttc',
        'numero_sim',
        'formule_premium',
        'montant_forfait_ttc',
        'code_puk',
        'acquisition_date',
        'statut',
        'cause_changement',
        'imsi',
    ];

    protected $casts = [
        'acquisition_date' => 'date',
    ];
}
