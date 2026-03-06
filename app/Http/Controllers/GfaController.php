<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use App\Models\Guichet;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GfaController extends Controller
{
    public function guichet(Guichet $guichet)
    {
        $user = Auth::user();

        $cards = [];

        // Card Administration visible uniquement pour ADMIN
        if ($user->role->name === 'ADMIN') {
            $cards[] = [
                'id'          => 0,
                'name'        => 'Administration',
                'header'      => 'Administration',
                'description' => 'Gestion administrative',
                'route'       => route('file-attente.overview'),
            ];
        }

        // Guichets dynamiques depuis la table agents
        foreach (Agent::orderBy('id')->get() as $agent) {
            $cards[] = [
                'id'          => $agent->id,
                'name'        => $agent->name,
                'header'      => $agent->name,
                'description' => $agent->info ?? 'Gestion du ' . $agent->name,
                'route'       => route('agent.dashboard', ['agent' => $agent->id]),
            ];
        }

        return view('gfa.dashboard', compact('cards', 'guichet', 'user'));
    }

    public function display()
    {
        return redirect()->away(
            "https://site-dt-app-production-e69724207a1f.herokuapp.com"
        );
    }

    public function index($guichet)
    {
        $agent = Agent::findOrFail($guichet);
        return redirect()->route('agent.dashboard', ['agent' => $agent->id]);
    }

    public function dashboard()
    {
        return redirect()->route('file-attente.overview');
    }
}
