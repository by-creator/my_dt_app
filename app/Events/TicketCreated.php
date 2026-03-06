<?php

namespace App\Events;

use App\Models\Ticket;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TicketCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public Ticket $ticket) {}

    public function broadcastOn(): Channel
    {
        return new Channel('tickets');
    }

    public function broadcastAs(): string
    {
        return 'TicketCreated';
    }

    public function broadcastWith(): array
    {
        return [
            'id'         => $this->ticket->id,
            'code'       => $this->ticket->code,
            'service_id' => $this->ticket->service_id,
        ];
    }
}
