<?php

namespace App\Http\Controllers;

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

        switch ($user->role->name) {
            case "ADMIN":
                $cards = [
                    [
                        'id' => 0,
                        'name' => 'Administration',
                        'header' => 'Administration',
                        'description' => 'Gestion administrative',
                        'route' => route('gfa.dashboard'),
                    ],
                    [
                        'id' => 1,
                        'name' => 'Guichet 1',
                        'header' => 'Guichet 1',
                        'description' => 'Gestion du guichet 1',
                        'route' => route('gfa.guichet', ['guichet' => 1]),
                    ],
                    [
                        'id' => 2,
                        'name' => 'Guichet 2',
                        'header' => 'Guichet 2',
                        'description' => 'Gestion du guichet 2',
                        'route' => route('gfa.guichet', ['guichet' => 2]),
                    ],
                    [
                        'id' => 3,
                        'name' => 'Guichet 3',
                        'header' => 'Guichet 3',
                        'description' => 'Gestion du guichet 3',
                        'route' => route('gfa.guichet', ['guichet' => 3]),
                    ],
                    [
                        'id' => 4,
                        'name' => 'Guichet 4',
                        'header' => 'Guichet 4',
                        'description' => 'Gestion du guichet 4',
                        'route' => route('gfa.guichet', ['guichet' => 4]),
                    ],
                    [
                        'id' => 5,
                        'name' => 'Guichet 5',
                        'header' => 'Guichet 5',
                        'description' => 'Gestion du guichet 5',
                        'route' => route('gfa.guichet', ['guichet' => 5]),
                    ],
                    [
                        'id' => 6,
                        'name' => 'Guichet 6',
                        'header' => 'Guichet 6',
                        'description' => 'Gestion du guichet 6',
                        'route' => route('gfa.guichet', ['guichet' => 6]),
                    ],
                    [
                        'id' => 7,
                        'name' => 'Guichet 7',
                        'header' => 'Guichet 7',
                        'description' => 'Gestion du guichet 7',
                        'route' => route('gfa.guichet', ['guichet' => 7]),
                    ],
                    [
                        'id' => 8,
                        'name' => 'Guichet 8',
                        'header' => 'Guichet 8',
                        'description' => 'Gestion du guichet 8',
                        'route' => route('gfa.guichet', ['guichet' => 8]),
                    ],
                    [
                        'id' => 9,
                        'name' => 'Guichet 9',
                        'header' => 'Guichet 9',
                        'description' => 'Gestion du guichet 9',
                        'route' => route('gfa.guichet', ['guichet' => 9]),
                    ],
                    [
                        'id' => 10,
                        'name' => 'Guichet 10',
                        'header' => 'Guichet 10',
                        'description' => 'Gestion du guichet 10',
                        'route' => route('gfa.guichet', ['guichet' => 10]),
                    ],
                    [
                        'id' => 11,
                        'name' => 'Guichet 11',
                        'header' => 'Guichet 11',
                        'description' => 'Gestion du guichet 11',
                        'route' => route('gfa.guichet', ['guichet' => 11]),
                    ],
                    [
                        'id' => 12,
                        'name' => 'Guichet 12',
                        'header' => 'Guichet 12',
                        'description' => 'Gestion du guichet 12',
                        'route' => route('gfa.guichet', ['guichet' => 12]),
                    ],
                    [
                        'id' => 13,
                        'name' => 'Guichet 13',
                        'header' => 'Guichet 13',
                        'description' => 'Gestion du guichet 13',
                        'route' => route('gfa.guichet', ['guichet' => 13]),
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
                        'route' => route('gfa.guichet', ['guichet' => 1]),
                    ],
                    [
                        'id' => 2,
                        'name' => 'Guichet 2',
                        'header' => 'Guichet 2',
                        'description' => 'Gestion du guichet 2',
                        'route' => route('gfa.guichet', ['guichet' => 2]),
                    ],
                    [
                        'id' => 3,
                        'name' => 'Guichet 3',
                        'header' => 'Guichet 3',
                        'description' => 'Gestion du guichet 3',
                        'route' => route('gfa.guichet', ['guichet' => 3]),
                    ],
                    [
                        'id' => 4,
                        'name' => 'Guichet 4',
                        'header' => 'Guichet 4',
                        'description' => 'Gestion du guichet 4',
                        'route' => route('gfa.guichet', ['guichet' => 4]),
                    ],
                    [
                        'id' => 5,
                        'name' => 'Guichet 5',
                        'header' => 'Guichet 5',
                        'description' => 'Gestion du guichet 5',
                        'route' => route('gfa.guichet', ['guichet' => 5]),
                    ],
                    [
                        'id' => 6,
                        'name' => 'Guichet 6',
                        'header' => 'Guichet 6',
                        'description' => 'Gestion du guichet 6',
                        'route' => route('gfa.guichet', ['guichet' => 6]),
                    ],
                    [
                        'id' => 7,
                        'name' => 'Guichet 7',
                        'header' => 'Guichet 7',
                        'description' => 'Gestion du guichet 7',
                        'route' => route('gfa.guichet', ['guichet' => 7]),
                    ],
                    [
                        'id' => 8,
                        'name' => 'Guichet 8',
                        'header' => 'Guichet 8',
                        'description' => 'Gestion du guichet 8',
                        'route' => route('gfa.guichet', ['guichet' => 8]),
                    ],
                    [
                        'id' => 9,
                        'name' => 'Guichet 9',
                        'header' => 'Guichet 9',
                        'description' => 'Gestion du guichet 9',
                        'route' => route('gfa.guichet', ['guichet' => 9]),
                    ],
                    [
                        'id' => 10,
                        'name' => 'Guichet 10',
                        'header' => 'Guichet 10',
                        'description' => 'Gestion du guichet 10',
                        'route' => route('gfa.guichet', ['guichet' => 10]),
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
                        'route' => route('gfa.guichet', ['guichet' => 11]),
                    ],
                    [
                        'id' => 12,
                        'name' => 'Guichet 12',
                        'header' => 'Guichet 12',
                        'description' => 'Gestion du guichet 12',
                        'route' => route('gfa.guichet', ['guichet' => 12]),
                    ],
                    [
                        'id' => 13,
                        'name' => 'Guichet 13',
                        'header' => 'Guichet 13',
                        'description' => 'Gestion du guichet 13',
                        'route' => route('gfa.guichet', ['guichet' => 13]),
                    ],
                ];
                break;
        }

        return view('agent.dashboard', compact('cards', 'guichet', 'user'));
    }

    public function index($guichet)
    {
        return redirect()->away(
            "https://site-dt-app-production-e69724207a1f.herokuapp.com/agent/{$guichet}"
        );
    }

    public function dashboard()
    {
        return redirect()->away(
            "https://site-dt-app-production-e69724207a1f.herokuapp.com/dashboard"
        );
    }
}
