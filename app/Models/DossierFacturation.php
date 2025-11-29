<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\ConvertsDates;

class DossierFacturation extends Model
{
    use HasFactory, ConvertsDates;

    protected $fillable = [
        'rattachement_bl_id',
        'date_proforma',
        'proforma',
        'facture',
        'bon',
    ];

    protected $casts = [
        'date_proforma' => 'datetime',
        'proforma' => 'array',
        'facture' => 'array',
        'bon' => 'array',
    ];

    public function getDateProformaFormattedAttribute()
    {
        return $this->date_proforma ? $this->date_proforma->format('d/m/Y H:i') : null;
    }

    public function rattachement()
    {
        return $this->belongsTo(RattachementBl::class);
    }
}
