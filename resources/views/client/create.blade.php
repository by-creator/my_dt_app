<!DOCTYPE html>
<html lang="fr">

<head>
    @include('partials.dashboard.head')
    <meta charset="UTF-8">
    <title>Choisissez un ticket</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f5f8fd;
        }

        .ticket-card {
            border-radius: 16px;
            padding: 30px;
            text-align: center;
            cursor: pointer;
            transition: all 0.25s ease;
            height: 100%;
        }

        .ticket-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
        }

        .ticket-icon {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 26px;
            color: #fff;
            margin: 0 auto 15px;
        }

        .ticket-title {
            font-weight: 600;
            font-size: 1.1rem;
        }
    </style>
</head>

<body>

    @php
        $topServices = $services->filter(fn($s) => in_array($s->nom, ['Validation', 'Facturation']));

        $bottomServices = $services->filter(fn($s) => in_array($s->nom, ['Caisse', 'Bad']));
    @endphp


    <div class="container py-5">

        {{-- En-tête --}}
        <div class="text-center mb-5">
            <img src="{{ asset('templates/mazer/dist/assets/images/logo/logo.png') }}" height="60" class="mb-3">
            <h2>Choisissez un ticket</h2>
        </div>

        {{-- Cartes services --}}
        <div class="row g-4 justify-content-center mb-4">
            @foreach ($topServices as $service)
                <div class="col-md-4 col-sm-6">
                    @include('ticket.card', ['service' => $service])
                </div>
            @endforeach
        </div>
        <div class="row g-4 justify-content-center">
            @foreach ($bottomServices as $service)
                <div class="col-md-4 col-sm-6">
                    @include('ticket.card', ['service' => $service])
                </div>
            @endforeach
        </div>
    </div>

</body>

</html>
