<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\ConvertsDates;


class RattachementBl extends Model
{
    use HasFactory, ConvertsDates;

    protected $fillable = [
        'user_id',
        'nom',
        'prenom',
        'email',
        'bl',
        'compte',
        'statut',
    ];


    protected $casts = ['created_at' => 'datetime', 'updated_at' => 'datetime'];

    /**
     * Accessor : retourne la durée écoulée entre created_at et updated_at
     */
    public function getTimeElapsedAttribute()
    {
        if (!$this->created_at || !$this->updated_at) {
            return null;
        }

        // Calcul de la différence en secondes
        $seconds = $this->updated_at->getTimestamp() - $this->created_at->getTimestamp();

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

    public static function secondsToHms($seconds)
    {
        $seconds = (int) $seconds;

        $hours = floor($seconds / 3600);
        $minutes = floor(($seconds % 3600) / 60);
        $seconds = $seconds % 60;

        return sprintf('%02dh %02dm %02ds', $hours, $minutes, $seconds);
    }




    public function getCreatedAtDateFormattedAttribute()
    {
        return $this->created_at ? $this->created_at->format('d/m/Y H:i') : null;
    }

    public function getUpdatedAtDateFormattedAttribute()
    {
        return $this->updated_at ? $this->updated_at->format('d/m/Y H:i') : null;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function dossierFacturation()
    {
        return $this->hasMany(DossierFacturation::class);
    }
}
