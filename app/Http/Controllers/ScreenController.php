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
}
