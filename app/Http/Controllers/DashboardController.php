<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class DashboardController extends Controller
{

    public function index()
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
                        'route' => route('role.index')
                    ],
                    [
                        'id' => 1,
                        'name' => 'Facturation',
                        'header' => 'Facturation',
                        'description' => 'Gestion Facturation',
                        'route' => route('rattachement.index')
                    ],
                    [
                        'id' => 2,
                        'name' => 'Informatique',
                        'header' => 'Informatique',
                        'description' => 'Gestion Informatique',
                        'route' => route('user_accounts.index')
                    ],
                    [
                        'id' => 3,
                        'name' => 'Ipaki Extranet (IES)',
                        'header' => 'Ipaki Extranet (IES)',
                        'description' => 'Gestion Ipaki Extranet (IES)',
                        'route' => route('ies.validation')
                    ],
                    [
                        'id' => 4,
                        'name' => 'Opérations',
                        'header' => 'Opérations',
                        'description' => 'Gestion des Opérations',
                        'route' => route('ordre_approche.index')
                    ],
                    [
                        'id' => 5,
                        'name' => 'Ressources Humanines',
                        'header' => 'Ressources Humaines',
                        'description' => 'Gestion des Ressources Humaines',
                        'route' => route('ordre_approche.index')
                    ],
                    [
                        'id' => 5,
                        'name' => 'Stock',
                        'header' => 'Stock',
                        'description' => 'Gestion de Stock',
                        'route' => route('ordinateur.index')
                    ],
                ];

                break;

            case "SUPER_U":
                $cards = [

                    [
                        'id' => 1,
                        'name' => 'Facturation',
                        'header' => 'Facturation',
                        'description' => 'Gestion Facturation',
                        'route' => route('rattachement.index')
                    ],
                    [
                        'id' => 2,
                        'name' => 'Informatique',
                        'header' => 'Informatique',
                        'description' => 'Gestion Informatique',
                        'route' => route('user_accounts.index')
                    ],
                    [
                        'id' => 3,
                        'name' => 'Ipaki Extranet (IES)',
                        'header' => 'Ipaki Extranet (IES)',
                        'description' => 'Gestion Ipaki Extranet (IES)',
                        'route' => route('ies.validation')
                    ],
                    [
                        'id' => 4,
                        'name' => 'Opérations',
                        'header' => 'Opérations',
                        'description' => 'Gestion des Opérations',
                        'route' => route('ordre_approche.index')
                    ],
                    [
                        'id' => 5,
                        'name' => 'Ressources Humanines',
                        'header' => 'Ressources Humaines',
                        'description' => 'Gestion des Ressources Humaines',
                        'route' => route('ordre_approche.index')
                    ],
                    [
                        'id' => 5,
                        'name' => 'Stock',
                        'header' => 'Stock',
                        'description' => 'Gestion de Stock',
                        'route' => route('ordinateur.index')
                    ],
                ];

                break;
            case "FACTURATION":
                $cards = [

                    [
                        'id' => 1,
                        'name' => 'Facturation',
                        'header' => 'Facturation',
                        'description' => 'Gestion Facturation',
                        'route' => route('rattachement.index')
                    ],

                ];

                break;
            case "OPERATIONS":
                $cards = [

                    [
                        'id' => 1,
                        'name' => 'Opérations',
                        'header' => 'Opérations',
                        'description' => 'Gestion des Opérations',
                        'route' => route('ordre_approche.index')
                    ],

                ];

                break;
        }

        return view('dashboard', compact('cards'));
    }

    public function logout()
    {
        Auth::guard('web')->logout();

        Session::invalidate();
        Session::regenerateToken();

        return redirect('/login');
    }
}
