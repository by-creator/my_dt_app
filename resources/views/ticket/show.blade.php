<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dakar-Terminal | Ticket</title>
    <link rel="icon" href="{{ asset('templates/fiche/assets/img/logo.png') }}">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: "Segoe UI", Arial, sans-serif;
            background: #eef2f7;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* ── HEADER ── */
        header {
            background: #ffffff;
            border-bottom: 1px solid #e2e8f0;
            padding: 14px 28px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        header img { height: 36px; }

        header .brand {
            font-size: 17px;
            font-weight: 700;
            color: #1e3a5f;
            letter-spacing: .02em;
        }

        header .sep { color: #cbd5e1; margin: 0 4px; }

        header .sub {
            font-size: 13px;
            color: #64748b;
            font-weight: 500;
        }

        /* ── MAIN ── */
        main {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
        }

        /* ── CARD ── */
        .ticket-card {
            background: #ffffff;
            border-radius: 20px;
            box-shadow: 0 8px 32px rgba(30, 58, 95, .10);
            width: 100%;
            max-width: 440px;
            overflow: hidden;
        }

        .card-header {
            background: linear-gradient(135deg, #1e3a8a 0%, #1d4ed8 100%);
            padding: 24px 32px;
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .card-header .icon {
            width: 48px;
            height: 48px;
            background: rgba(255,255,255,.15);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .card-header .icon svg { color: #fff; }

        .card-header .hd-text h2 {
            font-size: 20px;
            font-weight: 700;
            color: #ffffff;
        }

        .card-header .hd-text p {
            font-size: 13px;
            color: rgba(255,255,255,.7);
            margin-top: 2px;
        }

        .card-body {
            padding: 36px 32px 32px;
            text-align: center;
        }

        .label {
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .1em;
            color: #94a3b8;
            margin-bottom: 10px;
        }

        .ticket-number {
            font-size: 88px;
            font-weight: 800;
            color: #1e3a8a;
            line-height: 1;
            letter-spacing: 4px;
        }

        .divider {
            border: none;
            border-top: 1px solid #f1f5f9;
            margin: 28px 0;
        }

        .status-row {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin-bottom: 18px;
        }

        .status-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: #22c55e;
            animation: pulse 1.8s ease-in-out infinite;
            flex-shrink: 0;
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; transform: scale(1); }
            50%       { opacity: .5; transform: scale(.8); }
        }

        .status-text {
            font-size: 14px;
            font-weight: 600;
            color: #16a34a;
        }

        .ticket-info {
            font-size: 14px;
            color: #64748b;
            line-height: 1.65;
        }

        .ticket-info strong { color: #1e3a8a; }

        /* ── FOOTER ── */
        footer {
            text-align: center;
            padding: 18px;
            font-size: 12px;
            color: #94a3b8;
            border-top: 1px solid #e2e8f0;
            background: #ffffff;
        }

        @media (max-width: 480px) {
            .ticket-number { font-size: 68px; }
            .card-body { padding: 28px 22px 24px; }
        }
    </style>
</head>
<body>

    <header>
        <img src="{{ asset('templates/fiche/assets/img/logo.png') }}" alt="Dakar Terminal">
        <span class="brand">Dakar Terminal<span class="sep">|</span></span>
        <span class="sub">File d'attente</span>
    </header>

    <main>
        <div class="ticket-card">

            <div class="card-header">
                <div class="icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="2"
                         stroke-linecap="round" stroke-linejoin="round">
                        <path d="M2 9a3 3 0 0 1 0 6v2a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-2a3 3 0 0 1 0-6V7a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2z"/>
                        <path d="M13 5v2"/><path d="M13 17v2"/><path d="M13 11v2"/>
                    </svg>
                </div>
                <div class="hd-text">
                    <h2>Votre ticket</h2>
                    <p>{{ $ticket->service->name ?? 'Service' }}</p>
                </div>
            </div>

            <div class="card-body">
                <div class="label">Numéro d'appel</div>
                <div class="ticket-number">{{ $ticket->code }}</div>

                <hr class="divider">

                <div class="status-row">
                    <div class="status-dot"></div>
                    <span class="status-text">En attente d'appel</span>
                </div>

                <p class="ticket-info">
                    Veuillez patienter dans la salle d'attente.<br>
                    Votre numéro sera annoncé sur l'<strong>écran d'appel</strong>.
                </p>
            </div>

        </div>
    </main>

    <footer>
        &copy; {{ date('Y') }} &nbsp;·&nbsp; Dakar Terminal Sénégal
    </footer>

    <script>
        window.history.pushState(null, null, window.location.href);
        window.onpopstate = function () {
            window.location.replace("{{ route('ticket.create') }}");
        };
    </script>

</body>
</html>
