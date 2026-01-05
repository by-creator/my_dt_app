<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ticket</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            text-align: center;
        }

        .card {
            border: 1px solid #000;
            padding: 20px;
            margin-top: 40px;
        }
    </style>
</head>
<body>

<h1>🎫 Ticket</h1>

<div class="card">
    <h2 style="font-size:48px">{{ $ticket->numero }}</h2>
    <p>Service : <strong>{{ $ticket->service->nom }}</strong></p>
    <p>Heure : {{ $ticket->created_at->format('H:i') }}</p>
</div>

</body>
</html>
