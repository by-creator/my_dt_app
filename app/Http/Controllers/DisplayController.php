<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;

class DisplayController extends Controller
{
    public function index()
    {
        $tickets = Ticket::with('guichet')
            ->where('statut', 'en_cours')
            ->orderByDesc('appel_at')
            ->take(1)
            ->get();

        $ticketUrl = route('ticket.create');
        //$ticketUrl = "https://www.google.com/";

        // 🔑 Infos Wi-Fi
        $wifiSsid = 'DTLBOX23';
        $wifiPassword = 'P@sser=123';
        $wifiType = 'WPA';

        // 🔹 Texte QR Wi-Fi standard
        $wifiQr = "WIFI:T:$wifiType;S:$wifiSsid;P:$wifiPassword;;";

        return view('display.index', compact(
            'tickets',
            'ticketUrl',
            'wifiQr'
        ));
    }
}
