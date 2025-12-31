<?php

namespace App\Http\Controllers;

use App\Models\Guichet;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GuichetController extends Controller
{

    public function guichet(Guichet $guichet)
    {
        $user = Auth::user();
        $cards = [];

        switch ($user->role->name) {
            case "ADMIN":
                $cards = [
                    [
                        'id' => 1,
                        'name' => 'Guichet 1',
                        'header' => 'Guichet 1',
                        'description' => 'Gestion du guichet 1',
                        'route' => route('agent.guichet', ['guichet' => 1]),
                    ],
                    [
                        'id' => 2,
                        'name' => 'Guichet 2',
                        'header' => 'Guichet 2',
                        'description' => 'Gestion du guichet 2',
                        'route' => route('agent.guichet', ['guichet' => 2]),
                    ],
                    [
                        'id' => 3,
                        'name' => 'Guichet 3',
                        'header' => 'Guichet 3',
                        'description' => 'Gestion du guichet 3',
                        'route' => route('agent.guichet', ['guichet' => 3]),
                    ],
                    [
                        'id' => 4,
                        'name' => 'Guichet 4',
                        'header' => 'Guichet 4',
                        'description' => 'Gestion du guichet 4',
                        'route' => route('agent.guichet', ['guichet' => 4]),
                    ],
                    [
                        'id' => 5,
                        'name' => 'Guichet 5',
                        'header' => 'Guichet 5',
                        'description' => 'Gestion du guichet 5',
                        'route' => route('agent.guichet', ['guichet' => 5]),
                    ],
                    [
                        'id' => 6,
                        'name' => 'Guichet 6',
                        'header' => 'Guichet 6',
                        'description' => 'Gestion du guichet 6',
                        'route' => route('agent.guichet', ['guichet' => 6]),
                    ],
                    [
                        'id' => 7,
                        'name' => 'Guichet 7',
                        'header' => 'Guichet 7',
                        'description' => 'Gestion du guichet 7',
                        'route' => route('agent.guichet', ['guichet' => 7]),
                    ],
                    [
                        'id' => 8,
                        'name' => 'Guichet 8',
                        'header' => 'Guichet 8',
                        'description' => 'Gestion du guichet 8',
                        'route' => route('agent.guichet', ['guichet' => 8]),
                    ],
                    [
                        'id' => 9,
                        'name' => 'Guichet 9',
                        'header' => 'Guichet 9',
                        'description' => 'Gestion du guichet 9',
                        'route' => route('agent.guichet', ['guichet' => 9]),
                    ],
                    [
                        'id' => 10,
                        'name' => 'Guichet 10',
                        'header' => 'Guichet 10',
                        'description' => 'Gestion du guichet 10',
                        'route' => route('agent.guichet', ['guichet' => 10]),
                    ],
                    [
                        'id' => 11,
                        'name' => 'Guichet 11',
                        'header' => 'Guichet 11',
                        'description' => 'Gestion du guichet 11',
                        'route' => route('agent.guichet', ['guichet' => 11]),
                    ],
                    [
                        'id' => 12,
                        'name' => 'Guichet 12',
                        'header' => 'Guichet 12',
                        'description' => 'Gestion du guichet 12',
                        'route' => route('agent.guichet', ['guichet' => 12]),
                    ],
                    [
                        'id' => 13,
                        'name' => 'Guichet 13',
                        'header' => 'Guichet 13',
                        'description' => 'Gestion du guichet 13',
                        'route' => route('agent.guichet', ['guichet' => 13]),
                    ],
                    [
                        'id' => 14,
                        'name' => 'Administration',
                        'header' => 'Administration',
                        'description' => 'Gestion administrative',
                        'route' => route('admin.dashboard'),
                    ],
                ];
                break;
            case "FACTURATION":
                $cards = [
                    [
                        'id' => 1,
                        'name' => 'Guichet 1',
                        'header' => 'Guichet 1',
                        'description' => 'Gestion du guichet 1',
                        'route' => route('agent.guichet', ['guichet' => 1]),
                    ],
                    [
                        'id' => 2,
                        'name' => 'Guichet 2',
                        'header' => 'Guichet 2',
                        'description' => 'Gestion du guichet 2',
                        'route' => route('agent.guichet', ['guichet' => 2]),
                    ],
                    [
                        'id' => 3,
                        'name' => 'Guichet 3',
                        'header' => 'Guichet 3',
                        'description' => 'Gestion du guichet 3',
                        'route' => route('agent.guichet', ['guichet' => 3]),
                    ],
                    [
                        'id' => 4,
                        'name' => 'Guichet 4',
                        'header' => 'Guichet 4',
                        'description' => 'Gestion du guichet 4',
                        'route' => route('agent.guichet', ['guichet' => 4]),
                    ],
                    [
                        'id' => 5,
                        'name' => 'Guichet 5',
                        'header' => 'Guichet 5',
                        'description' => 'Gestion du guichet 5',
                        'route' => route('agent.guichet', ['guichet' => 5]),
                    ],
                    [
                        'id' => 6,
                        'name' => 'Guichet 6',
                        'header' => 'Guichet 6',
                        'description' => 'Gestion du guichet 6',
                        'route' => route('agent.guichet', ['guichet' => 6]),
                    ],
                    [
                        'id' => 7,
                        'name' => 'Guichet 7',
                        'header' => 'Guichet 7',
                        'description' => 'Gestion du guichet 7',
                        'route' => route('agent.guichet', ['guichet' => 7]),
                    ],
                    [
                        'id' => 8,
                        'name' => 'Guichet 8',
                        'header' => 'Guichet 8',
                        'description' => 'Gestion du guichet 8',
                        'route' => route('agent.guichet', ['guichet' => 8]),
                    ],
                    [
                        'id' => 9,
                        'name' => 'Guichet 9',
                        'header' => 'Guichet 9',
                        'description' => 'Gestion du guichet 9',
                        'route' => route('agent.guichet', ['guichet' => 9]),
                    ],
                    [
                        'id' => 10,
                        'name' => 'Guichet 10',
                        'header' => 'Guichet 10',
                        'description' => 'Gestion du guichet 10',
                        'route' => route('agent.guichet', ['guichet' => 10]),
                    ],
                ];
                break;

            case "CAISSE":
                $cards = [
                    [
                        'id' => 11,
                        'name' => 'Guichet 11',
                        'header' => 'Guichet 11',
                        'description' => 'Gestion du guichet 11',
                        'route' => route('agent.guichet', ['guichet' => 11]),
                    ],
                    [
                        'id' => 12,
                        'name' => 'Guichet 12',
                        'header' => 'Guichet 12',
                        'description' => 'Gestion du guichet 12',
                        'route' => route('agent.guichet', ['guichet' => 12]),
                    ],
                    [
                        'id' => 13,
                        'name' => 'Guichet 13',
                        'header' => 'Guichet 13',
                        'description' => 'Gestion du guichet 13',
                        'route' => route('agent.guichet', ['guichet' => 13]),
                    ],
                ];
                break;
        }

        return view('agent.dashboard', compact('cards', 'guichet','user'));
    }

    public function index(Guichet $guichet)
    {
         $user = Auth::user();
        // Ticket en cours pour CE guichet
        $ticketEnCours = Ticket::where('guichet_id', $guichet->id)
            ->where('statut', 'en_cours')
            ->latest()
            ->first();

        // 🔥 Tickets en attente pour le SERVICE du guichet
        $ticketsEnAttente = Ticket::where('service_id', $guichet->service_id)
            ->whereNull('guichet_id')
            ->where('statut', 'en_attente')
            ->orderBy('created_at')
            ->get();

        return view('agent.guichet', [
            'guichet' => $guichet,
            'ticketEnCours' => $ticketEnCours,
            'ticketsEnAttente' => $ticketsEnAttente,
            'enAttenteCount' => $ticketsEnAttente->count(),
            'user' => $user
        ]);
    }


    public function appeler(Guichet $guichet)
    {
        // 1️⃣ Vérifier qu’il n’y a pas déjà un ticket en cours
        $ticketEnCours = Ticket::where('guichet_id', $guichet->id)
            ->where('statut', 'en_cours')
            ->first();

        if ($ticketEnCours) {
            return back()->withErrors('Un client est déjà en cours.');
        }

        // 2️⃣ Prendre le PLUS ANCIEN ticket en attente du service
        $nextTicket = Ticket::where('service_id', $guichet->service_id)
            ->where('statut', 'en_attente')
            ->orderBy('created_at')
            ->first();

        if (!$nextTicket) {
            return back()->withErrors('Aucun client en attente.');
        }

        // 3️⃣ L’affecter au guichet
        $nextTicket->update([
            'guichet_id' => $guichet->id,
            'statut' => 'en_cours',
            'appel_at' => now(),
        ]);

        return back();
    }



    public function rappel(Ticket $ticket)
    {
        if ($ticket->statut !== 'en_cours') {
            return back()->with('error', 'Aucun ticket à rappeler.');
        }

        // 🔔 NOUVEL ÉVÈNEMENT D’APPEL
        $ticket->update([
            'appel_at' => now(),
        ]);

        return back()->with('success', 'Client rappelé.');
    }



    public function terminer(Ticket $ticket)
    {
        $ticket->update([
            'statut' => 'termine',
            'fin_at' => now(),
        ]);

        return back();
    }

    public function incomplet(Ticket $ticket)
    {
        $ticket->update([
            'statut' => 'incomplet',
            'fin_at' => now(),
        ]);

        return back()->with('success', 'Dossier marqué incomplet');
    }

    public function absent(Ticket $ticket)
    {
        $ticket->update([
            'statut' => 'absent',
            'fin_at' => now(),
        ]);

        return back()->with('success', 'Client marqué absent');
    }
}
