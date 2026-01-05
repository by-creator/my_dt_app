<!DOCTYPE html>
<html>

<head>
    @include('partials.dashboard.head')
    <title>Dakar-Terminal | Ticket</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        @media print {
            .no-print {
                display: none !important;
            }

            body {
                background: white !important;
            }

            .card {
                border: none !important;
                box-shadow: none !important;
            }

            h1 {
                margin-top: 20px;
            }
        }
    </style>

</head>

<body>
    <div class="container text-center">
        <h1>🎫 Votre ticket</h1>

        <div class="card p-4 mt-4">
            <h2 class="display-3">{{ $ticket->numero }}</h2>
            <p>Service : <strong>{{ $ticket->service->nom }}</strong></p>
            <p>Heure : {{ $ticket->created_at->format('H:i') }}</p>
        </div>

        <div class="mt-4 d-flex justify-content-center gap-3 no-print">
            
            <a href="{{ route('ticket.create') }}" class="btn btn-outline-secondary btn-lg">
                ➕ Nouveau ticket
            </a>

            <a href="{{ route('ticket.download', $ticket->id) }}" class="btn btn-outline-primary btn-lg">
                ⬇️ Télécharger
            </a>

            <button onclick="window.print()" class="btn btn-outline-secondary btn-lg">
                🖨️ Imprimer
            </button>
        </div>


    </div>
</body>

</html>
