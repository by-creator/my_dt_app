<!DOCTYPE html>
<html>
<head>
    @include('partials.dashboard.head')
    <title>Dakar-Terminal | Ticket</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container text-center">
    <h1>🎫 Votre ticket</h1>

    <div class="card p-4 mt-4">
        <h2 class="display-3">{{ $ticket->numero }}</h2>
        <p>Service : <strong>{{ $ticket->service->nom }}</strong></p>
        <p>Heure : {{ $ticket->created_at->format('H:i') }}</p>
    </div>

    <a href="{{ route('ticket.create') }}" class="btn btn-secondary mt-4">
        Nouveau ticket
    </a>
</div>
</body>
</html>
