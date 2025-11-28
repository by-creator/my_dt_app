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

        $diff = $this->updated_at->diff($this->created_at);

        // Exemple : "2 jours, 3 heures, 15 minutes"
        return $diff->d . ' jours, ' . $diff->h . ' heures, ' . $diff->i . ' minutes';
    }

    /**
     * Si tu veux un format "humain" style "il y a 5 minutes"
     */
    public function getTimeElapsedForHumansAttribute()
    {
        if (!$this->created_at || !$this->updated_at) {
            return null;
        }

        return $this->updated_at->diffForHumans($this->created_at, true);
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
