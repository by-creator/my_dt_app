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

        .page-wrapper {
            width: 100%;
            max-width: 520px;
        }

        /* ── TOP CARD (titre) ── */
        .top-card {
            background: #ffffff;
            border-radius: 20px;
            box-shadow: 0 8px 32px rgba(30, 58, 95, .10);
            overflow: hidden;
            margin-bottom: 20px;
        }

        .top-card-header {
            background: linear-gradient(135deg, #1e3a8a 0%, #1d4ed8 100%);
            padding: 22px 28px;
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .top-card-header .icon {
            width: 46px;
            height: 46px;
            background: rgba(255,255,255,.15);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .top-card-header .icon svg { color: #fff; }

        .top-card-header h2 {
            font-size: 19px;
            font-weight: 700;
            color: #ffffff;
        }

        .top-card-header p {
            font-size: 13px;
            color: rgba(255,255,255,.7);
            margin-top: 2px;
        }

        /* ── SERVICE CARDS ── */
        .service-card {
            background: #ffffff;
            border-radius: 16px;
            padding: 20px 22px;
            margin-bottom: 14px;
            display: flex;
            align-items: center;
            gap: 18px;
            cursor: pointer;
            border: 2px solid transparent;
            box-shadow: 0 4px 14px rgba(30, 58, 95, .07);
            transition: all .22s ease;
        }

        .service-card:hover {
            border-color: #1d4ed8;
            box-shadow: 0 8px 24px rgba(29, 78, 216, .15);
            transform: translateY(-2px);
        }

        .service-icon {
            width: 54px;
            height: 54px;
            background: linear-gradient(135deg, #1e3a8a 0%, #1d4ed8 100%);
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .service-icon svg { color: #fff; }

        .service-info { flex: 1; }

        .service-info .service-label {
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .08em;
            color: #94a3b8;
        }

        .service-info .service-name {
            font-size: 17px;
            font-weight: 700;
            color: #1e3a5f;
            margin-top: 3px;
        }

        .service-arrow {
            color: #94a3b8;
            flex-shrink: 0;
            transition: color .2s, transform .2s;
        }

        .service-card:hover .service-arrow {
            color: #1d4ed8;
            transform: translateX(4px);
        }

        .service-card form { display: none; }

        /* ── OVERLAY ── */
        #overlay {
            position: fixed;
            inset: 0;
            background: rgba(255,255,255,.95);
            z-index: 9999;
            display: none;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            gap: 14px;
            font-size: 16px;
            font-weight: 600;
            color: #1e3a5f;
        }

        .spinner {
            width: 40px;
            height: 40px;
            border: 4px solid #e5e7eb;
            border-top-color: #1d4ed8;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin { to { transform: rotate(360deg); } }

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
            .service-card { padding: 16px 16px; }
            .service-icon { width: 46px; height: 46px; border-radius: 12px; }
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
        <div class="page-wrapper">

            <div class="top-card">
                <div class="top-card-header">
                    <div class="icon">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="2"
                             stroke-linecap="round" stroke-linejoin="round">
                            <path d="M2 9a3 3 0 0 1 0 6v2a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-2a3 3 0 0 1 0-6V7a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2z"/>
                            <path d="M13 5v2"/><path d="M13 17v2"/><path d="M13 11v2"/>
                        </svg>
                    </div>
                    <div>
                        <h2>Choisissez votre service</h2>
                        <p>Sélectionnez un service pour obtenir un ticket</p>
                    </div>
                </div>
            </div>

            @foreach ($services as $service)
                <div class="service-card" onclick="openTicket(this)">
                    <div class="service-icon">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="2"
                             stroke-linecap="round" stroke-linejoin="round">
                            <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
                            <circle cx="9" cy="7" r="4"/>
                            <path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                        </svg>
                    </div>

                    <div class="service-info">
                        <div class="service-label">Service</div>
                        <div class="service-name">{{ $service->name }}</div>
                    </div>

                    <svg class="service-arrow" width="20" height="20" viewBox="0 0 24 24"
                         fill="none" stroke="currentColor" stroke-width="2"
                         stroke-linecap="round" stroke-linejoin="round">
                        <path d="M9 18l6-6-6-6"/>
                    </svg>

                    <form method="POST" action="{{ route('ticket.store') }}">
                        @csrf
                        <input type="hidden" name="service_id" value="{{ $service->id }}">
                        <input type="hidden" name="token" value="{{ $formToken }}">
                    </form>
                </div>
            @endforeach

        </div>
    </main>

    <footer>
        &copy; {{ date('Y') }} &nbsp;·&nbsp; Dakar Terminal Sénégal
    </footer>

    <div id="overlay">
        <div class="spinner"></div>
        Votre ticket est en cours de création...
    </div>

    <script>
        let ticketClicked = false;

        function openTicket(card) {
            if (ticketClicked) return;
            ticketClicked = true;

            document.getElementById('overlay').style.display = 'flex';
            document.querySelectorAll('.service-card').forEach(el => {
                el.style.opacity = '0.5';
                el.style.pointerEvents = 'none';
            });

            card.querySelector('form').submit();
        }

        window.history.pushState(null, null, window.location.href);
        window.addEventListener('popstate', function () {
            window.history.go(1);
        });
    </script>

</body>
</html>
