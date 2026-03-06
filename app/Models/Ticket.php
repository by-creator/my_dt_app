<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    const EN_ATTENTE = 'en_attente';
    const EN_COURS   = 'en_cours';
    const TERMINE    = 'termine';
    const ABSENT     = 'absent';
    const INCOMPLET  = 'incomplet';

    protected $fillable = [
        'service_id',
        'agent_id',
        'numero',
        'statut',
        'appel_at',
        'termine_at',
        'ip_address',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'appel_at'   => 'datetime',
        'termine_at' => 'datetime',
    ];

    protected $appends = ['duree_traitement'];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function agent()
    {
        return $this->belongsTo(Agent::class);
    }

    public function getCodeAttribute(): string
    {
        return "{$this->service->prefix}-{$this->numero}";
    }

    public function getTempsAttenteAttribute(): ?string
    {
        if (!$this->appel_at || !$this->created_at) {
            return null;
        }

        return gmdate('H:i:s', $this->created_at->diffInSeconds($this->appel_at));
    }

    public function getDureeTraitementAttribute(): ?string
    {
        if (!$this->appel_at || !$this->termine_at) {
            return null;
        }

        return gmdate('H:i:s', $this->appel_at->diffInSeconds($this->termine_at));
    }

    public function isClosable(): bool
    {
        return in_array($this->statut, [self::EN_COURS]);
    }
}
