<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use App\Models\Ticket;
use App\Events\TicketCalled;
use App\Events\TicketClosed;

class AgentPanelController extends Controller
{
    public function index(Agent $agent)
    {
        return view('agent.dashboard', [
            'agent' => $agent,

            'currentTicket' => Ticket::where('agent_id', $agent->id)
                ->where('statut', Ticket::EN_COURS)
                ->first(),

            'waitingTickets' => Ticket::where('service_id', $agent->service_id)
                ->where('statut', Ticket::EN_ATTENTE)
                ->orderBy('created_at')
                ->get(),
        ]);
    }

    public function call(Agent $agent)
    {
        // Ce guichet a déjà un client en cours
        if ($agent->tickets()->where('statut', Ticket::EN_COURS)->exists()) {
            return response()->json([
                'error'   => 'own_busy',
                'title'   => 'Client en cours de traitement',
                'message' => 'Vous avez un client en cours de traitement, merci de finir son traitement avant d\'appeler le suivant.',
            ], 409);
        }

        // Aucun client en attente
        $ticket = Ticket::where('service_id', $agent->service_id)
            ->where('statut', 'en_attente')
            ->orderBy('created_at')
            ->first();

        if (!$ticket) {
            return response()->json([
                'error'   => 'no_waiting',
                'title'   => 'File vide',
                'message' => 'Il n\'y a aucun client en attente.',
            ], 409);
        }

        $ticket->update([
            'statut'   => 'en_cours',
            'agent_id' => $agent->id,
            'appel_at' => now(),
        ]);

        event(new TicketCalled($ticket->load('service')));

        return response()->json([
            'status'    => 'Client appelé',
            'ticket_id' => $ticket->id,
            'code'      => $ticket->code,
        ]);
    }

    public function rappel(Agent $agent)
    {
        $ticket = Ticket::where('agent_id', $agent->id)
            ->where('statut', Ticket::EN_COURS)
            ->first();

        if (!$ticket) {
            return response()->json([
                'error'   => 'no_ticket',
                'title'   => 'Aucun client',
                'message' => 'Aucun client en cours à rappeler pour ce guichet.',
            ], 409);
        }

        $ticket->update(['appel_at' => now()]);

        event(new TicketCalled($ticket->load('service')));

        return response()->json(['status' => 'Client rappelé.']);
    }

    public function waiting(Agent $agent)
    {
        $tickets = Ticket::where('service_id', $agent->service_id)
            ->where('statut', Ticket::EN_ATTENTE)
            ->orderBy('created_at')
            ->get(['id', 'code', 'created_at']);

        return response()->json($tickets);
    }

    public function close(Agent $agent, Ticket $ticket, string $status)
    {
        abort_if($ticket->agent_id !== $agent->id, 403);

        $ticket->update([
            'statut'     => $status,
            'termine_at' => now(),
        ]);

        event(new TicketClosed($ticket));

        return response()->json(['status' => 'Ticket clôturé']);
    }
}
