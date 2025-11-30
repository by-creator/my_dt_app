<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\ConvertsDates;
use Carbon\Carbon;

class DossierFacturation extends Model
{
    use HasFactory, ConvertsDates;

    protected $fillable = [
        'rattachement_bl_id',
        'date_proforma',
    ];

    protected $casts = [
        'date_proforma' => 'datetime',
    ];

    public function getDateProformaFormattedAttribute()
    {
        return $this->date_proforma ? $this->date_proforma->format('d/m/Y H:i') : null;
    }

    public function getCreatedAtDateFormattedAttribute()
    {
        return $this->created_at ? $this->created_at->format('d/m/Y H:i') : null;
    }

    public function getUpdatedAtDateFormattedAttribute()
    {
        return $this->updated_at ? $this->updated_at->format('d/m/Y H:i') : null;
    }

    public function rattachement_bl()
    {
        return $this->belongsTo(RattachementBl::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function proforma()
    {
        return $this->hasOne(DossierFacturationProforma::class);
    }

    public function getTimeElapsedAttribute()
    {
        if (!$this->proforma || !$this->updated_at) {
            return null;
        }

        $start = Carbon::parse($this->proforma->created_at);
        $end   = Carbon::parse($this->updated_at);

        return $start->diffForHumans($end, true);
        // ex : "2 hours", "5 minutes"
    }

    public function getTimeElapsedForHumansAttribute()
    {
        $seconds = (int) $this->time_elapsed; // force en entier

        if ($seconds <= 0) {
            return null; // ou '—' si tu veux afficher quelque chose
        }

        $hours = floor($seconds / 3600);
        $minutes = floor(($seconds % 3600) / 60);
        $seconds = $seconds % 60;

        return sprintf('%02dh %02dm %02ds', $hours, $minutes, $seconds);
    }



    public function proformas()
    {
        return $this->hasMany(DossierFacturationProforma::class);
    }
    public function factures()
    {
        return $this->hasMany(DossierFacturationFacture::class);
    }
    public function bons()
    {
        return $this->hasMany(DossierFacturationBon::class);
    }
}
