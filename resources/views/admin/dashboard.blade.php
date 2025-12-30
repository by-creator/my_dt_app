@extends('partials.app')

@section('content')
<div class="container">
    <h2 class="mb-4">📊 Dashboard – Aujourd’hui</h2>

    {{-- KPIs --}}
    <div class="row text-center mb-4">
        <div class="col">🎟️ Total<br><strong>{{ $totalTickets }}</strong></div>
        <div class="col">⏳ En attente<br><strong>{{ $enAttente }}</strong></div>
        <div class="col">📢 En cours<br><strong>{{ $enCours }}</strong></div>
        <div class="col">✔ Terminés<br><strong>{{ $termines }}</strong></div>
        <div class="col">❌ Absents<br><strong>{{ $absents }}</strong></div>
    </div>

    <div class="alert alert-info">
        ⏱️ Temps moyen d’attente : <strong>{{ $tempsMoyen }} min</strong>
    </div>

    {{-- Stats par service --}}
    <h4 class="mt-4">📌 Par service</h4>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Service</th>
                <th>Total</th>
                <th>En attente</th>
                <th>Terminés</th>
            </tr>
        </thead>
        <tbody>
            @foreach($statsServices as $service)
            <tr>
                <td>{{ $service->nom }}</td>
                <td>{{ $service->total }}</td>
                <td>{{ $service->en_attente }}</td>
                <td>{{ $service->termines }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{-- Performance guichets --}}
    <h4 class="mt-4">👨‍💼 Performance des guichets</h4>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Guichet</th>
                <th>Tickets traités</th>
            </tr>
        </thead>
        <tbody>
            @foreach($statsGuichets as $g)
            <tr>
                <td>{{ $g->nom }}</td>
                <td>{{ $g->traites }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
