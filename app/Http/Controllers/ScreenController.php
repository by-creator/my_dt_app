<?php

namespace App\Http\Controllers;

use App\Models\Ticket;

class ScreenController extends Controller
{
    public function index()
    {
        $lastCalled = Ticket::where('statut', 'en_cours')
            ->with(['agent', 'service'])
            ->latest('appel_at')
            ->first();

        return view('public.screen', compact('lastCalled'));
    }

    public function status()
    {
        $ticket = Ticket::where('statut', 'en_cours')
            ->with(['agent', 'service'])
            ->latest('appel_at')
            ->first();

        if (!$ticket) {
            return response()->json(['active' => false]);
        }

        return response()->json([
            'active'     => true,
            'code'       => $ticket->code,
            'agent_name' => optional($ticket->agent)->name ?? 'Guichet ' . $ticket->agent_id,
        ]);
    }
}
