<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'EDI · Converter')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link
        href="https://fonts.googleapis.com/css2?family=Space+Mono:wght@400;700&family=DM+Sans:wght@300;400;500;600&display=swap"
        rel="stylesheet">

    <style>
        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        :root {
            --bg: #F0F4F8;
            --surface: #FFFFFF;
            --surface2: #E8EFF7;
            --border: rgba(30, 80, 160, .1);
            --border-h: rgba(0, 160, 145, .4);
            --cyan: #0097A7;
            --cyan-dim: rgba(0, 151, 167, .08);
            --cyan-glow: rgba(0, 151, 167, .2);
            --amber: #D97706;
            --red: #DC2626;
            --green: #059669;
            --text: #0F172A;
            --text-dim: #475569;
            --text-muted: #94A3B8;
            --mono: 'Space Mono', monospace;
            --sans: 'DM Sans', sans-serif;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: var(--sans);
            background: var(--bg);
            color: var(--text);
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* Subtle grid background */
        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background-image:
                linear-gradient(rgba(0, 151, 167, .05) 1px, transparent 1px),
                linear-gradient(90deg, rgba(0, 151, 167, .05) 1px, transparent 1px);
            background-size: 40px 40px;
            pointer-events: none;
            z-index: 0;
        }

        /* ── HEADER ── */
        header {
            position: sticky;
            top: 0;
            z-index: 100;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 2rem;
            background: rgba(255,255,255,.9);
            backdrop-filter: blur(16px);
            border-bottom: 1px solid rgba(30,80,160,.1);

        }

        .header-logo {
            display: flex;
            align-items: center;
            gap: .75rem;
            text-decoration: none;
        }

        .logo-icon {
            width: 34px;
            height: 34px;
            background: var(--cyan-dim);
            border: 1px solid var(--border-h);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .logo-icon svg {
            color: var(--cyan);
        }

        .logo-text {
            font-family: var(--mono);
            font-size: .9rem;
            font-weight: 700;
            color: var(--text);
            letter-spacing: .05em;
        }

        .logo-text span {
            color: var(--cyan);
        }

        .header-badge {
            font-family: var(--mono);
            font-size: .68rem;
            color: var(--text-dim);
            background: var(--surface2);
            border: 1px solid var(--border);
            padding: .25rem .65rem;
            border-radius: 20px;
            letter-spacing: .06em;
        }

        /* ── MAIN ── */
        main {
            position: relative;
            z-index: 1;
            max-width: 900px;
            margin: 0 auto;
            padding: 3rem 1.5rem 5rem;
        }

        /* ── BUTTONS ── */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: .5rem;
            padding: .7rem 1.5rem;
            border-radius: 8px;
            border: none;
            font-family: var(--sans);
            font-size: .875rem;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            transition: all .2s;
            letter-spacing: .01em;
        }

        .btn-cyan {
    background: var(--cyan);
    color: #FFFFFF;
}

        .btn-cyan:hover {
            background: #00f5de;
            box-shadow: 0 0 24px var(--cyan-glow);
            transform: translateY(-1px);
        }

        .btn-ghost {
            background: transparent;
            color: var(--text-dim);
            border: 1px solid var(--border);
        }

        .btn-ghost:hover {
            color: var(--text);
            border-color: var(--border-h);
            background: var(--cyan-dim);
        }

        /* ── ALERTS ── */
        .alert {
            padding: 1rem 1.25rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            font-size: .875rem;
            border: 1px solid;
        }

        .alert-error {
            background: rgba(239, 68, 68, .08);
            border-color: rgba(239, 68, 68, .3);
            color: #FCA5A5;
        }

        footer {
            position: relative;
            z-index: 1;
            text-align: center;
            padding: 1.5rem;
            font-size: .75rem;
            color: var(--text-muted);
            border-top: 1px solid var(--border);
            font-family: var(--mono);
            letter-spacing: .05em;
        }
    </style>

    @stack('styles')
</head>

<body>

    <header>
        <a href="{{ route('edi.index') }}" class="header-logo">
            <div class="logo-icon">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="2" y="3" width="20" height="14" rx="2" />
                    <line x1="8" y1="21" x2="16" y2="21" />
                    <line x1="12" y1="17" x2="12" y2="21" />
                </svg>
            </div>
            <span class="logo-text">EDI<span>·</span>CONVERTER</span>
        </a>
        <div class="header-badge">DAKAR-TERMINAL</div>
    </header>

    <main>
        @yield('content')
    </main>

    <footer>
        © {{ date('Y') }} &nbsp;·&nbsp; EDI CONVERTER &nbsp;·&nbsp; GRANDE ABIDJAN
    </footer>

    @yield('scripts')

</body>

</html>
