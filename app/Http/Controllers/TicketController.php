<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\Ticket;
use App\Models\TicketLog;

class TicketController extends Controller
{
    public function create()
    {
        $services = Service::all();
        return view('client.create', compact('services'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'service_id' => 'required|exists:services,id',
            'priorite' => 'nullable|in:normal,prioritaire'
        ]);

        // Numéro journalier (A001, A002…)
        $countToday = Ticket::whereDate('created_at', today())->count() + 1;

        $ticket = Ticket::create([
            'numero' => 'A' . str_pad($countToday, 3, '0', STR_PAD_LEFT),
            'service_id' => $request->service_id,
            'priorite' => $request->priorite ?? 'normal',
        ]);

        TicketLog::create([
            'ticket_id' => $ticket->id,
            'action' => 'ticket_cree'
        ]);

        return view('client.ticket', compact('ticket'));
    }
}
