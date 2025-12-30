<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $fillable = [
        'numero',
        'service_id',
        'priorite',
        'statut',
        'guichet_id',
        'appel_at',
        'fin_at'
    ];

    protected $casts = [
        'appel_at' => 'datetime',
        'fin_at' => 'datetime',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function guichet()
    {
        return $this->belongsTo(Guichet::class);
    }

    public function logs()
    {
        return $this->hasMany(TicketLog::class);
    }
}
