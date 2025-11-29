<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\ConvertsDates;

class DossierFacturation extends Model
{
    use HasFactory, ConvertsDates;

    protected $fillable = [
        'date_proforma',

        'proforma',
        'proforma_original_name',

        'facture',
        'facture_original_name',

        'bon',
        'bon_original_name',

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
