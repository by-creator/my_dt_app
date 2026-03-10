<?php

namespace App\Events;

use App\Models\Ticket;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TicketCalled implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public Ticket $ticket) {}

    public function broadcastOn(): array
    {
        return [
            new Channel('tickets'),
            new Channel('agent.' . $this->ticket->agent_id),
        ];
    }

    public function broadcastAs(): string
    {
        return 'TicketCalled';
    }

    public function broadcastWith(): array
    {
        $agentName = optional(\App\Models\Agent::find($this->ticket->agent_id))->name
                     ?? 'Guichet ' . $this->ticket->agent_id;

        return [
            'id'         => $this->ticket->id,
            'code'       => $this->ticket->code,
            'agent'      => $this->ticket->agent_id,
            'agent_name' => $agentName,
        ];
    }
}
