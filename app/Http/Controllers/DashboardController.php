<?php

namespace App\Http\Controllers;

use App\Models\DossierFacturation;
use App\Models\RattachementBl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Models\Ticket;
use App\Models\Service;
use App\Models\Guichet;

class DashboardController extends Controller
{

    public function index(Request $request)
    {
        $email = Auth::user()->email;
        $search = $request->get('search');
        $user = Auth::user();

        // --- Sous-requête : derniers rattachements par BL ---
        $subQuery = DB::table('rattachement_bls')
            ->selectRaw('MAX(id) as last_id')
            ->where('email', $email)
            ->groupBy('bl');

        // --- Requête principale ---
        $query = DossierFacturation::with('rattachement_bl')
            ->whereIn('rattachement_bl_id', $subQuery);

        // --- Filtre recherche ---
        if (!empty($search)) {
            $query->whereHas('rattachement_bl', function ($q) use ($search) {
                $q->where('bl', 'LIKE', "%{$search}%");
            });
        }

        // --- Pagination ---
        $dossiers = $query->orderBy('id', 'desc')
            ->paginate(3)
            ->withQueryString();

        // --- Rattachements pour affichage ---
        $rattachements = RattachementBl::where('email', $email)->get();


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
                        'name' => 'Orde d\'approches',
                        'header' => 'Orde d\'approches',
                        'description' => 'Gestion des ordre d\'approches',
                        'route' => route('ordre_approche.index')
                    ],

                    [
                        'id' => 4,
                        'name' => 'Ressources Humanines',
                        'header' => 'Ressources Humaines',
                        'description' => 'Gestion des Ressources Humaines',
                        'route' => route('ordre_approche.index')
                    ],
                    [
                        'id' => 5,
                        'name' => 'Planification',
                        'header' => 'Planification',
                        'description' => 'Gestion de Planification',
                        'route' => route('planification.index')
                    ],
                    [
                        'id' => 6,
                        'name' => 'Stock',
                        'header' => 'Stock',
                        'description' => 'Gestion de Stock',
                        'route' => route('ordinateur.index')
                    ],
                    [
                        'id' => 7,
                        'name' => 'Ticket',
                        'header' => 'Ticket',
                        'description' => 'Gestion de Ticket',
                        'route' => route('agent.guichet.me')
                    ],

                    [
                        'id' => 8,
                        'name' => 'Rapport',
                        'header' => 'Rapport',
                        'description' => 'Gestion de Rapport',
                        'route' => route('rapport.index')
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
                        'name' => 'Orde d\'approches',
                        'header' => 'Orde d\'approches',
                        'description' => 'Gestion des ordre d\'approches',
                        'route' => route('ordre_approche.index')
                    ],

                    [
                        'id' => 4,
                        'name' => 'Ressources Humanines',
                        'header' => 'Ressources Humaines',
                        'description' => 'Gestion des Ressources Humaines',
                        'route' => route('ordre_approche.index')
                    ],
                    [
                        'id' => 5,
                        'name' => 'Planification',
                        'header' => 'Planification',
                        'description' => 'Gestion de Planification',
                        'route' => route('planification.index')
                    ],
                    [
                        'id' => 6,
                        'name' => 'Stock',
                        'header' => 'Stock',
                        'description' => 'Gestion de Stock',
                        'route' => route('ordinateur.index')
                    ],
                    [
                        'id' => 7,
                        'name' => 'Ticket',
                        'header' => 'Ticket',
                        'description' => 'Gestion de Ticket',
                        'route' => route('agent.guichet.me')
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
                    [
                        'id' => 2,
                        'name' => 'Ticket',
                        'header' => 'Ticket',
                        'description' => 'Gestion de Ticket',
                        'route' => route('agent.guichet.me')
                    ],

                ];
                break;
            case "CAISSE":
                $cards = [
                    [
                        'id' => 1,
                        'name' => 'Ticket',
                        'header' => 'Ticket',
                        'description' => 'Gestion de Ticket',
                        'route' => route('agent.guichet.me')
                    ],

                ];

                break;
            case "OPERATIONS":
                $cards = [

                    [
                        'id' => 1,
                        'name' => 'Orde d\'approches',
                        'header' => 'Orde d\'approches',
                        'description' => 'Gestion des ordre d\'approches',
                        'route' => route('ordre_approche.index')
                    ],

                ];

                break;

                case "PLANIFICATION":
                $cards = [

                    [
                        'id' => 1,
                        'name' => 'Planification',
                        'header' => 'Planification',
                        'description' => 'Gestion de Planification',
                        'route' => route('planification.index')
                    ],

                ];

                break;
        }

        return view('dashboard', compact('cards', 'dossiers', 'rattachements','user'));
    }

    public function logout()
    {
        Auth::guard('web')->logout();

        Session::invalidate();
        Session::regenerateToken();

        return redirect('/login');
    }

    public function dashboard()
    {
        $today = today();

        // KPIs globaux
        $totalTickets = Ticket::whereDate('created_at', $today)->count();

        $enAttente = Ticket::where('statut', 'en_attente')->count();
        $enCours   = Ticket::where('statut', 'en_cours')->count();
        $termines  = Ticket::whereDate('fin_at', $today)
            ->where('statut', 'termine')->count();
        $absents   = Ticket::whereDate('fin_at', $today)
            ->where('statut', 'absent')->count();

        // Temps moyen d’attente (en minutes)
        $tempsMoyen = Ticket::whereNotNull('appel_at')
            ->whereDate('created_at', $today)
            ->avg(DB::raw('TIMESTAMPDIFF(SECOND, created_at, appel_at)'));

        $tempsMoyen = round(($tempsMoyen ?? 0) / 60, 2);

        // Stats par service
        $statsServices = Service::withCount([
            'tickets as total',
            'tickets as en_attente' => function ($q) {
                $q->where('statut', 'en_attente');
            },
            'tickets as termines' => function ($q) {
                $q->where('statut', 'termine');
            }
        ])->get();

        // Performance guichets
        $statsGuichets = Guichet::withCount([
            'tickets as traites' => function ($q) {
                $q->where('statut', 'termine');
            }
        ])->get();

        return view('admin.dashboard', compact(
            'totalTickets',
            'enAttente',
            'enCours',
            'termines',
            'absents',
            'tempsMoyen',
            'statsServices',
            'statsGuichets'
        ));
    }
}
