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
        --red: #DC2626;
        --green: #059669;
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

    .edi-inner {
        position: relative;
        z-index: 1;
        max-width: 820px;
        margin: 0 auto;
    }

    /* ── HERO ── */
    .hero { text-align: center; padding: 2rem 0 2.5rem; animation: fadeUp .6s ease both; }
    .hero-eyebrow {
        display: inline-flex; align-items: center; gap: .5rem;
        font-family: var(--mono); font-size: .7rem; letter-spacing: .12em;
        color: var(--cyan); background: var(--cyan-dim); border: 1px solid var(--border-h);
        padding: .35rem .85rem; border-radius: 20px; margin-bottom: 1.5rem; text-transform: uppercase;
    }
    .hero-eyebrow::before {
        content: ''; width: 6px; height: 6px; background: var(--cyan);
        border-radius: 50%; animation: pulse 2s infinite;
    }
    .hero h1 {
        font-family: var(--mono); font-size: clamp(1.8rem, 4vw, 2.8rem);
        font-weight: 700; line-height: 1.1; letter-spacing: -.02em;
        margin-bottom: 1rem; color: var(--text);
    }
    .hero h1 em { font-style: normal; color: var(--cyan); }
    .hero p { font-size: 1rem; color: var(--text-dim); max-width: 480px; margin: 0 auto; line-height: 1.7; font-weight: 300; }

    /* ── UPLOAD CARD ── */
    .upload-card {
        background: var(--surface); border: 1px solid var(--border);
        border-radius: 16px; padding: 2.5rem;
        animation: fadeUp .6s .15s ease both; position: relative; overflow: hidden;
    }
    .upload-card::before {
        content: ''; position: absolute; top: 0; left: 0; right: 0; height: 1px;
        background: linear-gradient(90deg, transparent, var(--cyan), transparent); opacity: .5;
    }

    /* ── DROP ZONE ── */
    .drop-zone {
        position: relative; border: 2px dashed rgba(0, 151, 167, .25);
        border-radius: 12px; padding: 3.5rem 2rem; text-align: center;
        cursor: pointer; transition: all .25s; background: rgba(0, 210, 190, .02);
    }
    .drop-zone:hover, .drop-zone.dragover {
        border-color: var(--cyan); background: var(--cyan-dim);
        box-shadow: 0 0 40px rgba(0, 210, 190, .08);
    }
    .drop-zone input[type="file"] { position: absolute; inset: 0; opacity: 0; cursor: pointer; width: 100%; height: 100%; }
    .drop-icon {
        width: 60px; height: 60px; margin: 0 auto 1.25rem;
        background: var(--cyan-dim); border: 1px solid var(--border-h); border-radius: 14px;
        display: flex; align-items: center; justify-content: center;
        transition: transform .25s, box-shadow .25s; color: var(--cyan);
    }
    .drop-zone:hover .drop-icon { transform: translateY(-3px); box-shadow: 0 8px 24px var(--cyan-glow); }
    .drop-title { font-size: 1rem; font-weight: 600; color: var(--text); margin-bottom: .4rem; }
    .drop-sub { font-size: .825rem; color: var(--text-dim); }
    .drop-sub code {
        font-family: var(--mono); font-size: .75rem; background: var(--surface2);
        border: 1px solid var(--border); padding: .1rem .4rem; border-radius: 4px; color: var(--cyan);
    }
    .file-selected {
        display: none; align-items: center; gap: .75rem; margin-top: 1rem;
        padding: .75rem 1rem; background: rgba(16, 185, 129, .08);
        border: 1px solid rgba(16, 185, 129, .25); border-radius: 8px;
        font-size: .85rem; color: #0F172A; font-family: var(--mono);
    }
    .file-selected.visible { display: flex; }

    /* ── SUBMIT ── */
    .btn-submit {
        width: 100%; justify-content: center; margin-top: 1.5rem; padding: .9rem;
        font-size: .95rem; border-radius: 10px; background: var(--cyan); color: #fff;
        font-weight: 700; letter-spacing: .02em; transition: all .25s; border: none;
        cursor: pointer; display: flex; align-items: center; gap: .6rem; font-family: var(--sans);
    }
    .btn-submit:hover { background: #00f5de; box-shadow: 0 0 30px var(--cyan-glow), 0 4px 16px rgba(0,0,0,.3); transform: translateY(-1px); }
    .btn-submit:disabled { opacity: .5; cursor: not-allowed; transform: none; box-shadow: none; }

    /* ── BTN ── */
    .btn {
        display: inline-flex; align-items: center; gap: .5rem;
        padding: .7rem 1.5rem; border-radius: 8px; border: none;
        font-family: var(--sans); font-size: .875rem; font-weight: 600;
        cursor: pointer; text-decoration: none; transition: all .2s; letter-spacing: .01em;
    }
    .btn-cyan { background: var(--cyan); color: #fff; }
    .btn-cyan:hover { background: #00f5de; box-shadow: 0 0 24px var(--cyan-glow); transform: translateY(-1px); }

    /* ── ALERT ── */
    .alert-error {
        padding: 1rem 1.25rem; border-radius: 8px; margin-bottom: 1.5rem;
        font-size: .875rem; background: rgba(239,68,68,.08);
        border: 1px solid rgba(239,68,68,.3); color: #DC2626;
    }

    /* ── FEATURES ── */
    .features { display: flex; flex-direction: row; gap: 1rem; margin-top: 1.5rem; animation: fadeUp .6s .3s ease both; flex-wrap: wrap; }
    .feature { background: var(--surface); border: 1px solid var(--border); border-radius: 10px; padding: 1.1rem 1.25rem; transition: border-color .2s, transform .2s; flex: 1; min-width: 160px; }
    .feature:hover { border-color: var(--border-h); transform: translateY(-2px); }
    .feature-icon { font-size: 1.3rem; margin-bottom: .5rem; }
    .feature-title { font-size: .8rem; font-weight: 600; color: var(--text); margin-bottom: .3rem; font-family: var(--mono); letter-spacing: .04em; }
    .feature-desc { font-size: .75rem; color: var(--text-dim); line-height: 1.5; }

    /* ── SPECS BAR ── */
    .specs-bar {
        display: flex; align-items: center; gap: 1rem; padding: 1rem 1.5rem;
        background: var(--surface2); border: 1px solid var(--border); border-radius: 10px;
        margin-top: 1rem; flex-wrap: nowrap; overflow-x: auto; white-space: nowrap;
        animation: fadeUp .6s .45s ease both;
    }
    .spec-item { display: flex; align-items: center; gap: .5rem; font-family: var(--mono); font-size: .72rem; color: var(--text-dim); letter-spacing: .04em; }
    .spec-item strong { color: var(--cyan); font-weight: 700; }
    .spec-dot { width: 3px; height: 3px; background: var(--text-muted); border-radius: 50%; }

    @keyframes fadeUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
    @keyframes pulse { 0%, 100% { opacity: 1; } 50% { opacity: .3; } }
    @keyframes spin { to { transform: rotate(360deg); } }
</style>
@endpush

@section('content')
<div id="main" class="edi-main">
<div class="edi-inner">

    {{-- ERRORS --}}
    @if ($errors->any())
        <div class="alert-error" style="animation: fadeUp .4s ease both;">
            @foreach ($errors->all() as $error)
                <div>⚠ {{ $error }}</div>
            @endforeach
        </div>
    @endif

    {{-- HERO --}}
    <div class="hero">
        <div class="hero-eyebrow">Système EDI</div>
        <h1>Transformez vos fichiers<br><em>EDI en IFTMIN / EXCEL</em></h1>
        <p>Parsez instantanément vos manifestes de cargaison en fichier IFTMIN / EXCEL structuré, prêt à l'analyse.</p>
    </div>

    {{-- UPLOAD CARD --}}
    <div class="upload-card">
        <form id="convertForm" action="{{ route('edi.preview') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="drop-zone" id="dropZone">
                <input type="file" name="edi_file" id="ediFile" accept=".txt,text/plain" required>

                <div class="drop-icon">
                    <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                        <polyline points="14 2 14 8 20 8" />
                        <line x1="12" y1="18" x2="12" y2="12" />
                        <line x1="9" y1="15" x2="15" y2="15" />
                    </svg>
                </div>

                <div class="drop-title">Déposez votre fichier EDI ici</div>
                <div class="drop-sub">ou cliquez pour sélectionner &nbsp;·&nbsp; Format <code>.txt</code> &nbsp;·&nbsp; Max <code>50 Mo</code></div>
            </div>

            <div class="file-selected" id="fileSelected">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="20 6 9 17 4 12" />
                </svg>
                <span id="fileName">—</span>
            </div>

            <button type="submit" class="btn-submit" id="submitBtn">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="11" cy="11" r="8" />
                    <line x1="21" y1="21" x2="16.65" y2="16.65" />
                </svg>
                Analyser et prévisualiser
            </button>
        </form>
    </div>

    {{-- FEATURES --}}
    <div class="features">
        <div class="feature">
            <div class="feature-icon">🚢</div>
            <div class="feature-title">LOC / RFF / TDT</div>
            <div class="feature-desc">Ports, numéro B/L, voyage et call number.</div>
        </div>
        <div class="feature">
            <div class="feature-icon">📦</div>
            <div class="feature-title">SGP / EQD / SEL</div>
            <div class="feature-desc">Conteneur, châssis, type équipement et scellés.</div>
        </div>
        <div class="feature">
            <div class="feature-icon">🏢</div>
            <div class="feature-title">NAD (FW/CZ/CN/N1)</div>
            <div class="feature-desc">Expéditeur, consignataire, agent et notify parties.</div>
        </div>
        <div class="feature">
            <div class="feature-icon">⚖️</div>
            <div class="feature-title">MEA / GID / FTX</div>
            <div class="feature-desc">Poids, volume, quantité et description marchandise.</div>
        </div>
    </div>

    {{-- SPECS BAR --}}
    <div class="specs-bar">
        <div class="spec-item">Format <strong>IFTMIN / EXCEL D04 96B UN</strong></div>
        <div class="spec-dot"></div>
        <div class="spec-item">Standard <strong>UN/EDIFACT</strong></div>
        <div class="spec-dot"></div>
        <div class="spec-item">Encodage <strong>Latin-1</strong></div>
        <div class="spec-dot"></div>
        <div class="spec-item"><strong>1 bloc</strong> UNH/UNT par B/L</div>
        <div class="spec-dot"></div>
        <div class="spec-item">Aperçu <strong>avant téléchargement</strong></div>
    </div>

</div>
</div>
@endsection

@push('scripts')
<script>
    const dropZone   = document.getElementById('dropZone');
    const fileInput  = document.getElementById('ediFile');
    const fileName   = document.getElementById('fileName');
    const fileSelected = document.getElementById('fileSelected');
    const submitBtn  = document.getElementById('submitBtn');
    const form       = document.getElementById('convertForm');

    function setFile(file) {
        fileName.textContent = file.name + ' (' + (file.size / 1024).toFixed(0) + ' Ko)';
        fileSelected.classList.add('visible');
    }

    fileInput.addEventListener('change', () => { if (fileInput.files.length) setFile(fileInput.files[0]); });

    dropZone.addEventListener('dragover', e => { e.preventDefault(); dropZone.classList.add('dragover'); });
    dropZone.addEventListener('dragleave', () => dropZone.classList.remove('dragover'));
    dropZone.addEventListener('drop', e => {
        e.preventDefault(); dropZone.classList.remove('dragover');
        const files = e.dataTransfer.files;
        if (files.length) { fileInput.files = files; setFile(files[0]); }
    });

    form.addEventListener('submit', () => {
        submitBtn.disabled = true;
        submitBtn.innerHTML = `
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="animation:spin 1s linear infinite">
            <path d="M21 12a9 9 0 1 1-6.219-8.56"/>
        </svg>
        Analyse en cours…`;
    });
</script>
@endpush
