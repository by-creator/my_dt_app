@extends('layouts.app')

@section('content')
    <style>
        body { background: #f5f7fb; }

        .dashboard-container {
            max-width: 1200px;
            margin: auto;
            padding: 30px 20px;
        }

        .dashboard-title {
            font-size: 32px;
            font-weight: 800;
            color: #1e293b;
            margin-bottom: 30px;
        }

        .table-card {
            background: white;
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, .06);
        }

        .table-card h4 {
            font-size: 22px;
            font-weight: 700;
            margin-bottom: 20px;
            color: #1e293b;
        }
    </style>

    <div class="dashboard-container">

        <div class="dashboard-title">📊 Suivi des tickets</div>

        <div class="table-card">
            <h4>Détail des tickets traités (par ticket)</h4>

            <div class="d-flex gap-2 align-items-center flex-wrap">
                <form method="GET" class="d-flex gap-2">
                    <select name="agent_id" class="form-select">
                        <option value="">Tous les guichets</option>
                        @foreach ($agents as $agent)
                            <option value="{{ $agent->id }}"
                                {{ request('agent_id') == $agent->id ? 'selected' : '' }}>
                                {{ $agent->name }}
                            </option>
                        @endforeach
                    </select>

                    <select name="statut" class="form-select">
                        <option value="">Tous statuts</option>
                        <option value="termine"  {{ request('statut') === 'termine'  ? 'selected' : '' }}>Terminé</option>
                        <option value="absent"   {{ request('statut') === 'absent'   ? 'selected' : '' }}>Absent</option>
                        <option value="incomplet"{{ request('statut') === 'incomplet'? 'selected' : '' }}>Incomplet</option>
                    </select>

                    <input type="date" name="date" class="form-control" value="{{ request('date') }}">

                    <button class="btn btn-light">🔍</button>

                    <a href="{{ route('gfa.tickets-detail') }}" class="btn btn-light">♻️</a>

                    <a href="{{ route('gfa.tickets-detail.export', request()->query()) }}" class="btn btn-light">📥</a>
                </form>

                <form action="{{ route('tickets.truncate') }}" method="POST"
                      onsubmit="return confirm('⚠️ Cette action supprimera tous les tickets. Continuer ?')">
                    @csrf
                    <button type="submit" class="btn btn-light">🗑️</button>
                </form>
            </div>

            <br>

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Ticket</th>
                        <th>Guichet</th>
                        <th>Infos du guichet</th>
                        <th>Temps d'attente</th>
                        <th>Heure appel</th>
                        <th>Heure fin</th>
                        <th>Durée de traitement</th>
                        <th>Statut</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tickets as $ticket)
                        <tr>
                            <td>{{ $ticket->code }}</td>
                            <td>{{ $ticket->agent->name ?? '—' }}</td>
                            <td>{{ $ticket->agent->info ?? '—' }}</td>
                            <td>{{ $ticket->temps_attente ?? '—' }}</td>
                            <td>{{ $ticket->appel_at?->format('H:i:s') }}</td>
                            <td>{{ $ticket->termine_at?->format('H:i:s') }}</td>
                            <td>{{ $ticket->duree_traitement ?? '—' }}</td>
                            <td>
                                @switch($ticket->statut)
                                    @case('termine')
                                        <span class="badge bg-success">Terminé</span>
                                    @break
                                    @case('absent')
                                        <span class="badge bg-danger">Absent</span>
                                    @break
                                    @case('incomplet')
                                        <span class="badge bg-info text-dark">Incomplet</span>
                                    @break
                                @endswitch
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{ $tickets->links() }}
        </div>

    </div>
@endsection
