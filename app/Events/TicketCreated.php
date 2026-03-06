<?php

namespace App\Events;

use App\Models\Agent;
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

    public function broadcastOn(): array
    {
        // Canal public pour l'écran + un canal par agent du même service
        $agentChannels = Agent::where('service_id', $this->ticket->service_id)
            ->pluck('id')
            ->map(fn($id) => new Channel("agent.{$id}"))
            ->all();

        return array_merge([new Channel('tickets')], $agentChannels);
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
