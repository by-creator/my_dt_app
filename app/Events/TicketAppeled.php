<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TicketAppeled implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $ticket;


    /**
     * Create a new event instance.
     */
    public function __construct($ticket)
    {
        $this->ticket = $ticket->load('guichet');
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn()
    {
        return new Channel('queue-channel');
    }

    public function broadcastAs()
    {
        return 'ticket.called';
    }

    public function broadcastWith()
    {
        return [
            'numero' => $this->ticket->numero,
            'guichet' => [
                'nom' => $this->ticket->guichet->nom,
            ],
        ];
    }
}
