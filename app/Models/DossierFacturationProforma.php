<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\ConvertsDates;

class DossierFacturationProforma extends Model
{
    use HasFactory, ConvertsDates;

    protected $fillable = [
        'dossier_facturation_id',
        'proforma',
        'user',
        'bl',
        'statut',
        'time_elapsed'
    ];

    protected $casts = [
        'proforma' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'

    ];

    public function getCreatedAtDateFormattedAttribute()
    {
        return $this->created_at ? $this->created_at->format('d/m/Y H:i') : null;
    }

    public function getUpdatedAtDateFormattedAttribute()
    {
        return $this->updated_at ? $this->updated_at->format('d/m/Y H:i') : null;
    }

    public function dossier()
    {
        return $this->belongsTo(DossierFacturation::class);
    }
}
