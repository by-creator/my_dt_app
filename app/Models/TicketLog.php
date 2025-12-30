<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TicketLog extends Model
{
    public $timestamps = false;

    protected $fillable = ['ticket_id', 'action'];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }
}
