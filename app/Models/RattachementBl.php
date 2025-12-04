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

        // Différence brute en secondes
        $seconds = $this->updated_at->diffInSeconds($this->created_at);

        if ($seconds <= 0) {
            return null;
        }

        // Calcul détaillé
        $days = floor($seconds / 86400); // 24 * 60 * 60
        $hours = floor(($seconds % 86400) / 3600);
        $minutes = floor(($seconds % 3600) / 60);
        $seconds = $seconds % 60;

        // Construction dynamique du résultat
        $parts = [];

        if ($days > 0) {
            $parts[] = sprintf('%02dj', $days);
        }

        $parts[] = sprintf('%02dh', $hours);
        $parts[] = sprintf('%02dm', $minutes);
        $parts[] = sprintf('%02ds', $seconds);

        return implode(' ', $parts);
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
