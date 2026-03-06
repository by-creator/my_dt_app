<?php

namespace App\Http\Controllers;

use App\Models\DossierFacturation;
use App\Models\RattachementBl;
use App\Models\Agent;
use App\Models\Ticket;
use App\Exports\TicketsDetailExport;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Facades\Excel;




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
                        'id' => 9,
                        'name' => 'Douane',
                        'header' => 'Douane',
                        'description' => 'Gestion de Douane',
                        'route' => route('douane.index')
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
                        'name' => 'Opérations',
                        'header' => 'Opérations',
                        'description' => 'Gestion des opérations',
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
                        'id' => 8,
                        'name' => 'Rapport',
                        'header' => 'Rapport',
                        'description' => 'Gestion de Rapport',
                        'route' => route('rapport.index')
                    ],
                    [
                        'id' => 4,
                        'name' => 'Ressources Humanines',
                        'header' => 'Ressources Humaines',
                        'description' => 'Gestion des Ressources Humaines',
                        'route' => route('ordre_approche.index')
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
                        'route' => route('gfa.guichet.me')
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
                        'name' => 'Opérations',
                        'header' => 'Opérations',
                        'description' => 'Gestion des opérations',
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
                        'id' => 4,
                        'name' => 'Ressources Humanines',
                        'header' => 'Ressources Humaines',
                        'description' => 'Gestion des Ressources Humaines',
                        'route' => route('ordre_approche.index')
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
                        'route' => route('gfa.guichet.me')
                    ],
                ];
                break;

                case "DIRECTION_GENERALE":
                $cards = [
                    [
                        'id' => 1,
                        'name' => 'Remises',
                        'header' => 'Remises',
                        'description' => 'Gestion Des Remises',
                        'route' => route('rattachement.index_remise')
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
                        'route' => route('gfa.guichet.me')
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
                        'route' => route('gfa.guichet.me')
                    ],
                ];
                break;

            case "OPERATIONS":
                $cards = [
                    [
                        'id' => 1,
                        'name' => 'Opérations',
                        'header' => 'Opérations',
                        'description' => 'Gestion des opérations',
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

        
        return view('dashboard', compact('cards', 'dossiers', 'rattachements', 'user'));
    }

    public function logout()
    {
        Auth::guard('web')->logout();

        Session::invalidate();
        Session::regenerateToken();

        return redirect('/login');
    }

    /* =====================================================
       FILE D'ATTENTE – TICKETS DETAIL
       ===================================================== */

    public function gfaTicketsDetail(Request $request)
    {
        $agents = Agent::all();

        $tickets = Ticket::with('agent')
            ->whereNotNull('appel_at')
            ->whereNotNull('termine_at')
            ->when($request->filled('agent_id'), fn($q) => $q->where('agent_id', $request->agent_id))
            ->when($request->filled('statut'),   fn($q) => $q->where('statut', $request->statut))
            ->when($request->filled('date'),     fn($q) => $q->whereDate('appel_at', $request->date))
            ->orderByDesc('appel_at')
            ->paginate(5)
            ->appends($request->query());

        $tickets->getCollection()->transform(function ($ticket) {
            $ticket->temps_attente = ($ticket->created_at && $ticket->appel_at)
                ? Carbon::parse($ticket->created_at)->diff($ticket->appel_at)->format('%H:%I:%S')
                : null;

            $ticket->duree_traitement = ($ticket->appel_at && $ticket->termine_at)
                ? Carbon::parse($ticket->appel_at)->diff($ticket->termine_at)->format('%H:%I:%S')
                : null;

            return $ticket;
        });

        return view('gfa.tickets-detail', compact('tickets', 'agents'));
    }

    public function gfaExportTicketsDetail(Request $request)
    {
        $date = Carbon::now()->format('d-m-Y');

        return Excel::download(
            new TicketsDetailExport($request),
            "{$date}_tickets_detail.xlsx"
        );
    }
}
