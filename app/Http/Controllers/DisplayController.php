<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;


class DisplayController extends Controller
{
    public function index()
    {
        $ticket = Cache::remember(
            'display_current_ticket',
            now()->addSeconds(10), // ⏱ cache 10 secondes
            function () {
                return Ticket::with('guichet')
                    ->where('statut', 'en_cours')
                    ->orderByDesc('appel_at')
                    ->first(); // 🔑 PAS get()
            }
        );

        $ticketUrl = route('ticket.create');

        // Wi-Fi
        $wifiQr = "WIFI:T:WPA;S:DTLBOX23;P:P@sser=123;;";

        return view('display.index', [
            'tickets'   => $ticket ? collect([$ticket]) : collect(),
            'ticketUrl' => $ticketUrl,
            'wifiQr'    => $wifiQr,
        ]);
    }
}
