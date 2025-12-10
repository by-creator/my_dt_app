<?php

namespace App\Models;

use App\Enums\StatutDossier;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\ConvertsDates;
use Carbon\Carbon;

class DossierFacturation extends Model
{
    use HasFactory, ConvertsDates;

    protected $fillable = [
        'user_id',
        'rattachement_bl_id',
        'date_proforma',
        'statut',
        'time_elapsed_proforma',
        'time_elapsed_facture',
        'time_elapsed_bon',
    ];

    protected $casts = [
        'date_proforma' => 'datetime',
        'statut' => StatutDossier::class,
        'relance_proforma' => 'boolean',
        'relance_facture' => 'boolean',
        'relance_bad' => 'boolean',
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
/*
    public function getTimeElapsedProformaAttribute()
    {
        if (!$this->time_elapsed_proforma) {
            return null;
        }

        $seconds = (int) $this->time_elapsed_proforma;

        if ($seconds <= 0) {
            return null;
        }

        // Calcul jours, heures, minutes, secondes
        $days = floor($seconds / 86400); // 24 * 3600
        $hours = floor(($seconds % 86400) / 3600);
        $minutes = floor(($seconds % 3600) / 60);
        $seconds = $seconds % 60;

        // Construction dynamique du format
        $parts = [];

        if ($days > 0) {
            $parts[] = sprintf('%02dj', $days);
        }

        $parts[] = sprintf('%02dh', $hours);
        $parts[] = sprintf('%02dm', $minutes);
        $parts[] = sprintf('%02ds', $seconds);

        return implode(' ', $parts);
    }

    public function getTimeElapsedFactureAttribute()
    {
        if (!$this->time_elapsed_facture) {
            return null;
        }

        $seconds = (int) $this->time_elapsed_facture;

        if ($seconds <= 0) {
            return null;
        }

        // Calcul jours, heures, minutes, secondes
        $days = floor($seconds / 86400); // 24 * 3600
        $hours = floor(($seconds % 86400) / 3600);
        $minutes = floor(($seconds % 3600) / 60);
        $seconds = $seconds % 60;

        // Construction dynamique du format
        $parts = [];

        if ($days > 0) {
            $parts[] = sprintf('%02dj', $days);
        }

        $parts[] = sprintf('%02dh', $hours);
        $parts[] = sprintf('%02dm', $minutes);
        $parts[] = sprintf('%02ds', $seconds);

        return implode(' ', $parts);
    }


    public function getTimeElapsedBonAttribute()
    {
        if (!$this->time_elapsed_bon) {
            return null;
        }

        $seconds = (int) $this->time_elapsed_bon;

        if ($seconds <= 0) {
            return null;
        }

        // Calcul jours, heures, minutes, secondes
        $days = floor($seconds / 86400); // 24 * 3600
        $hours = floor(($seconds % 86400) / 3600);
        $minutes = floor(($seconds % 3600) / 60);
        $seconds = $seconds % 60;

        // Construction dynamique du format
        $parts = [];

        if ($days > 0) {
            $parts[] = sprintf('%02dj', $days);
        }

        $parts[] = sprintf('%02dh', $hours);
        $parts[] = sprintf('%02dm', $minutes);
        $parts[] = sprintf('%02ds', $seconds);

        return implode(' ', $parts);
    }
*/

    public static function secondsToHms($seconds)
    {
        $seconds = (int) $seconds;

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
