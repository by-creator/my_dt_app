@extends('partials.app')

@push('head')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Space+Mono:wght@400;700&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
<style>
    /* ── EDI CSS VARIABLES ── */
    :root {
        --edi-bg: #F0F4F8;
        --surface: #FFFFFF;
        --surface2: #E8EFF7;
        --border: rgba(30, 80, 160, .1);
        --border-h: rgba(0, 160, 145, .4);
        --cyan: #0097A7;
        --cyan-dim: rgba(0, 151, 167, .08);
        --cyan-glow: rgba(0, 151, 167, .2);
        --amber: #D97706;
        --text: #0F172A;
        --text-dim: #475569;
        --text-muted: #94A3B8;
        --mono: 'Space Mono', monospace;
        --sans: 'DM Sans', sans-serif;
    }

    .edi-main {
        font-family: var(--sans);
        background: var(--edi-bg);
        min-height: 100vh;
        padding: 2.5rem 1.5rem 5rem;
        position: relative;
    }

    .edi-main::before {
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

    .edi-inner { position: relative; z-index: 1; max-width: 100%; }

    /* ── BTN ── */
    .btn {
        display: inline-flex; align-items: center; gap: .5rem;
        padding: .7rem 1.5rem; border-radius: 8px; border: none;
        font-family: var(--sans); font-size: .875rem; font-weight: 600;
        cursor: pointer; text-decoration: none; transition: all .2s; letter-spacing: .01em;
    }
    .btn-cyan { background: var(--cyan); color: #fff; }
    .btn-cyan:hover { background: #00f5de; box-shadow: 0 0 24px var(--cyan-glow); transform: translateY(-1px); }

    /* ── PAGE HEADER ── */
    .page-header {
        display: flex; align-items: flex-start; justify-content: space-between;
        gap: 1.5rem; margin-bottom: 2rem; flex-wrap: wrap; animation: fadeUp .5s ease both;
    }
    .page-title { font-family: var(--mono); font-size: 1.5rem; font-weight: 700; color: var(--text); letter-spacing: -.01em; }
    .page-title span { color: var(--cyan); }
    .page-sub { font-size: .85rem; color: var(--text-dim); margin-top: .3rem; font-weight: 300; }
    .header-actions { display: flex; gap: .75rem; flex-shrink: 0; flex-wrap: wrap; }

    /* ── STATS GRID ── */
    .stats-grid {
        display: grid; grid-template-columns: repeat(4, 1fr); gap: 1rem;
        margin-bottom: 1.75rem; animation: fadeUp .5s .1s ease both;
    }
    @media (max-width: 700px) { .stats-grid { grid-template-columns: repeat(2, 1fr); } }

    .stat-card {
        background: var(--surface); border: 1px solid var(--border); border-radius: 12px;
        padding: 1.25rem 1.5rem; position: relative; overflow: hidden;
        transition: border-color .2s, transform .2s;
    }
    .stat-card:hover { border-color: var(--border-h); transform: translateY(-2px); }
    .stat-card::after {
        content: ''; position: absolute; bottom: 0; left: 0; right: 0; height: 2px;
        background: linear-gradient(90deg, var(--cyan), transparent); opacity: 0; transition: opacity .2s;
    }
    .stat-card:hover::after { opacity: 1; }
    .stat-label { font-family: var(--mono); font-size: .65rem; letter-spacing: .1em; text-transform: uppercase; color: var(--text-dim); margin-bottom: .6rem; }
    .stat-value { font-family: var(--mono); font-size: 2rem; font-weight: 700; color: var(--cyan); line-height: 1; }
    .stat-desc { font-size: .75rem; color: var(--text-muted); margin-top: .35rem; }

    /* ── TABLE WRAPPER ── */
    .table-wrapper {
        background: var(--surface); border: 1px solid var(--border); border-radius: 14px;
        overflow: hidden; animation: fadeUp .5s .2s ease both; position: relative; max-width: 100%;
    }
    .table-toolbar {
        display: flex; align-items: center; justify-content: space-between;
        padding: 1rem 1.25rem; border-bottom: 1px solid var(--border); gap: 1rem; flex-wrap: wrap;
    }
    .table-title {
        font-family: var(--mono); font-size: .8rem; font-weight: 700; color: var(--text);
        letter-spacing: .06em; text-transform: uppercase; display: flex; align-items: center; gap: .6rem;
    }
    .table-title::before { content: ''; display: inline-block; width: 8px; height: 8px; background: var(--cyan); border-radius: 2px; }

    .search-input {
        background: var(--surface2); border: 1px solid var(--border); border-radius: 8px;
        padding: .45rem .9rem .45rem 2.2rem; font-size: .82rem; color: var(--text);
        font-family: var(--sans); width: 220px; transition: border-color .2s, box-shadow .2s; outline: none;
    }
    .search-input::placeholder { color: var(--text-muted); }
    .search-input:focus { border-color: var(--border-h); box-shadow: 0 0 0 3px var(--cyan-dim); }
    .search-wrap { position: relative; }
    .search-wrap svg { position: absolute; left: .65rem; top: 50%; transform: translateY(-50%); color: var(--text-muted); pointer-events: none; }

    /* ── TABLE ── */
    .table-scroll {
        overflow-x: auto; overflow-y: auto; max-height: 600px; width: 100%; -webkit-overflow-scrolling: touch;
    }
    .table-scroll::-webkit-scrollbar { height: 10px; width: 6px; }
    .table-scroll::-webkit-scrollbar-track { background: var(--surface2); border-radius: 0 0 14px 14px; }
    .table-scroll::-webkit-scrollbar-thumb { background: rgba(0,151,167,.35); border-radius: 10px; border: 2px solid var(--surface2); }
    .table-scroll::-webkit-scrollbar-thumb:hover { background: var(--cyan); }

    .edi-main table { width: 100%; border-collapse: collapse; font-size: .78rem; white-space: nowrap; min-width: max-content; }
    .edi-main thead { position: sticky; top: 0; z-index: 10; }
    .edi-main thead th {
        background: #0A1220; color: #fff; padding: .65rem 1rem;
        font-family: var(--mono); font-weight: 700; font-size: .65rem; text-align: left;
        letter-spacing: .08em; text-transform: uppercase;
        border-right: 1px solid var(--border); border-bottom: 1px solid var(--border); user-select: none;
    }
    .edi-main thead th.col-num { width: 44px; text-align: center; background: #060C18; color: var(--text-muted); }
    .edi-main thead th:hover { color: var(--cyan); }
    .edi-main tbody tr { transition: background .15s; }
    .edi-main tbody tr:nth-child(even) { background: rgba(255,255,255,.02); }
    .edi-main tbody tr:hover { background: rgba(0,210,190,.05); }
    .edi-main tbody tr.hidden-row { display: none; }
    .edi-main tbody td {
        padding: .5rem 1rem; border-bottom: 1px solid rgba(255,255,255,.03);
        border-right: 1px solid rgba(255,255,255,.03); color: var(--text);
        max-width: 200px; overflow: hidden; text-overflow: ellipsis;
    }
    .edi-main tbody td.col-num {
        text-align: center; color: var(--text-muted); font-family: var(--mono);
        font-size: .7rem; background: rgba(0,0,0,.15); width: 44px;
    }
    .edi-main tbody td:empty::after { content: '—'; color: var(--text-muted); opacity: .4; }

    /* ── TABLE FOOTER ── */
    .table-footer {
        display: flex; align-items: center; justify-content: space-between;
        padding: .85rem 1.25rem; border-top: 1px solid var(--border);
        font-size: .78rem; color: var(--text-dim); flex-wrap: wrap; gap: .5rem;
    }
    .truncate-notice { display: flex; align-items: center; gap: .5rem; color: var(--text); font-family: var(--mono); font-size: .72rem; }

    /* ── DOWNLOAD CTA ── */
    .download-cta {
        margin-top: 2rem; background: var(--surface); border: 1px solid var(--border);
        border-radius: 14px; padding: 2rem; display: flex; align-items: center;
        justify-content: space-between; gap: 1.5rem; flex-wrap: wrap;
        animation: fadeUp .5s .35s ease both; position: relative; overflow: hidden;
    }
    .download-cta::before {
        content: ''; position: absolute; inset: 0;
        background: radial-gradient(ellipse at 80% 50%, rgba(0,210,190,.05), transparent 60%);
        pointer-events: none;
    }
    .cta-text h3 { font-family: var(--mono); font-size: 1rem; font-weight: 700; color: var(--text); margin-bottom: .35rem; }
    .cta-text p { font-size: .83rem; color: var(--text-dim); }
    .cta-text .timer {
        display: inline-flex; align-items: center; gap: .4rem;
        font-family: var(--mono); font-size: .7rem; color: var(--amber);
        margin-top: .5rem; background: rgba(245,158,11,.08);
        border: 1px solid rgba(245,158,11,.2); padding: .2rem .6rem; border-radius: 4px;
    }
    .btn-download {
        display: inline-flex; align-items: center; gap: .65rem; padding: .9rem 2rem;
        background: var(--cyan); color: #fff; border: none; border-radius: 10px;
        font-size: .95rem; font-weight: 700; cursor: pointer; text-decoration: none;
        font-family: var(--sans); transition: all .25s; flex-shrink: 0; letter-spacing: .01em;
    }
    .btn-download:hover { background: #00f5de; box-shadow: 0 0 30px var(--cyan-glow), 0 4px 16px rgba(0,0,0,.3); transform: translateY(-2px); }

    @keyframes fadeUp { from { opacity: 0; transform: translateY(16px); } to { opacity: 1; transform: translateY(0); } }
    @keyframes spin { to { transform: rotate(360deg); } }
</style>
@endpush

@section('content')
<div id="main" class="edi-main">
<div class="edi-inner">

    {{-- PAGE HEADER --}}
    <div class="page-header">
        <div>
            <div class="page-title">Aperçu <span>/ {{ $totalCount }} enregistrements</span></div>
            <div class="page-sub">
                @if ($totalCount > 50)
                    Affichage des 50 premières lignes — le fichier IFTMIN contiendra l'intégralité.
                @else
                    Toutes les lignes sont affichées ci-dessous.
                @endif
            </div>
        </div>
        <div class="header-actions">
            <a href="{{ route('edi.index') }}" class="btn btn-cyan">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="19" y1="12" x2="5" y2="12" /><polyline points="12 19 5 12 12 5" />
                </svg>
                Nouveau fichier
            </a>
            <a href="{{ route('edi.download.xlsx', $token) }}" class="btn btn-cyan" id="dlBtnXlsxTop">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" /><polyline points="7 10 12 15 17 10" /><line x1="12" y1="15" x2="12" y2="3" />
                </svg>
                Télécharger Excel
            </a>
            <a href="{{ route('edi.download', $token) }}" class="btn btn-cyan" id="dlBtnTop">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" /><polyline points="7 10 12 15 17 10" /><line x1="12" y1="15" x2="12" y2="3" />
                </svg>
                Télécharger IFTMIN
            </a>
        </div>
    </div>

    {{-- STATS --}}
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-label">Enregistrements</div>
            <div class="stat-value">{{ $totalCount }}</div>
            <div class="stat-desc">lignes parsées</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Colonnes</div>
            <div class="stat-value">{{ count($headers) }}</div>
            <div class="stat-desc">champs extraits</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">B/L uniques</div>
            <div class="stat-value">{{ $previewRows->pluck('data')->pluck('bl_number')->filter()->unique()->count() }}</div>
            <div class="stat-desc">sur l'aperçu</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Transports</div>
            <div class="stat-value">{{ $previewRows->pluck('data')->pluck('transport_mode')->filter()->unique()->count() }}</div>
            <div class="stat-desc">modes détectés</div>
        </div>
    </div>

    {{-- TABLE --}}
    <div class="table-wrapper">
        <div class="table-toolbar">
            <div class="table-title">Données extraites</div>
            <div class="search-wrap">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="11" cy="11" r="8" /><line x1="21" y1="21" x2="16.65" y2="16.65" />
                </svg>
                <input type="text" class="search-input" id="tableSearch" placeholder="Filtrer les données…">
            </div>
        </div>

        <div class="table-scroll">
            <table id="dataTable">
                <thead>
                    <tr>
                        <th class="col-num">#</th>
                        @foreach ($headers as $key => $label)
                            <th>{{ $label }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach ($previewRows as $i => $record)
                        <tr>
                            <td class="col-num">{{ $i + 1 }}</td>
                            @foreach (array_keys($headers) as $key)
                                <td title="{{ $record->data[$key] ?? '' }}">{{ $record->data[$key] ?? '' }}</td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div id="showMoreBar" style="display:none; text-align:center; padding:.75rem; border-top:1px solid var(--border);">
            <button onclick="showAllRows()"
                style="background:var(--cyan-dim);border:1px solid var(--border-h);color:var(--cyan);font-family:var(--mono);font-size:.75rem;letter-spacing:.06em;padding:.4rem 1.2rem;border-radius:6px;cursor:pointer;">
                AFFICHER TOUTES LES LIGNES
            </button>
        </div>

        <div class="table-footer">
            <span id="rowCount">{{ $previewRows->count() }} lignes affichées</span>
            @if ($totalCount > 50)
                <span class="truncate-notice">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10" /><line x1="12" y1="8" x2="12" y2="12" /><line x1="12" y1="16" x2="12.01" y2="16" />
                    </svg>
                    Tous les {{ $totalCount }} enregistrements sont inclus dans le fichier généré.
                </span>
            @endif
        </div>
    </div>

    {{-- DOWNLOAD CTA --}}
    <div class="download-cta">
        <div class="cta-text">
            <h3>Prêt à exporter ?</h3>
            <p>Le fichier IFTMIN contiendra les {{ $totalCount }} enregistrements, formatés avec en-têtes, filtres et mise en page professionnelle.</p>
            <div class="timer">
                <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10" /><polyline points="12 6 12 12 16 14" />
                </svg>
                Lien valide 30 minutes
            </div>
        </div>
        <a href="{{ route('edi.download.xlsx', $token) }}" class="btn btn-cyan" id="dlBtnXlsxBottom">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" /><polyline points="7 10 12 15 17 10" /><line x1="12" y1="15" x2="12" y2="3" />
            </svg>
            Télécharger Excel
        </a>
        <a href="{{ route('edi.download', $token) }}" class="btn-download" id="dlBtnBottom">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" /><polyline points="7 10 12 15 17 10" /><line x1="12" y1="15" x2="12" y2="3" />
            </svg>
            Télécharger le fichier IFTMIN
        </a>
    </div>

</div>
</div>
@endsection

@push('scripts')
<script>
    const searchInput = document.getElementById('tableSearch');
    const rows        = document.querySelectorAll('#dataTable tbody tr');
    const rowCount    = document.getElementById('rowCount');
    const showMoreBar = document.getElementById('showMoreBar');

    if ({{ $totalCount }} > 50) showMoreBar.style.display = 'block';

    function showAllRows() {
        rows.forEach(r => r.classList.remove('hidden-row'));
        showMoreBar.style.display = 'none';
        rowCount.textContent = rows.length + ' lignes affichées';
    }

    searchInput.addEventListener('input', function() {
        const q = this.value.toLowerCase().trim();
        let visible = 0;
        rows.forEach(row => {
            const match = !q || row.textContent.toLowerCase().includes(q);
            row.classList.toggle('hidden-row', !match);
            if (match) visible++;
        });
        rowCount.textContent = visible + ' ligne' + (visible > 1 ? 's' : '') + ' affichée' + (visible > 1 ? 's' : '');
        showMoreBar.style.display = 'none';
    });

    document.querySelectorAll('#dlBtnTop, #dlBtnBottom').forEach(btn => {
        btn.addEventListener('click', function() {
            this.style.opacity = '.6';
            this.style.pointerEvents = 'none';
            const original = this.innerHTML;
            this.innerHTML = `<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="animation:spin 1s linear infinite"><path d="M21 12a9 9 0 1 1-6.219-8.56"/></svg> Génération…`;
            setTimeout(() => { this.innerHTML = original; this.style.opacity = ''; this.style.pointerEvents = ''; }, 8000);
        });
    });
</script>
@endpush
