@extends('partials.app')

@section('sidebar-menu')
    @include('partials.file_attente.menu')
@endsection

@section('content')
<style>
    .overview-wrapper { padding: 30px; background: #f5f7fb; min-height: 100vh; }
    .overview-wrapper h1 { font-size: 26px; font-weight: 700; color: #1e293b; margin-bottom: 30px; }
    .service-block { margin-bottom: 30px; }
    .service-name {
        font-size: 16px;
        font-weight: 700;
        color: #1e40af;
        text-transform: uppercase;
        letter-spacing: .5px;
        margin-bottom: 12px;
    }
    .stat-grid { display: flex; gap: 14px; flex-wrap: wrap; }
    .stat-card {
        flex: 1;
        min-width: 140px;
        background: #fff;
        border-radius: 12px;
        padding: 18px 16px;
        text-align: center;
        border: 2px solid transparent;
    }
    .stat-card .label { font-size: 13px; color: #64748b; margin-bottom: 6px; }
    .stat-card .value { font-size: 32px; font-weight: 800; color: #1e293b; }

    .stat-card.attente  { border-color: #1e293b; }
    .stat-card.en-cours { border-color: #f59e0b; }
    .stat-card.termine  { border-color: #10b981; }
    .stat-card.incomplet{ border-color: #06b6d4; }
    .stat-card.absent   { border-color: #ef4444; }
</style>

<div id="main" class="overview-wrapper">
    <h1>📊 Informations générales</h1>

    @forelse($services as $service)
        <div class="service-block">
            <div class="service-name">{{ $service->name }}</div>
            <div class="stat-grid">
                <div class="stat-card attente">
                    <div class="label">En attente</div>
                    <div class="value">{{ $service->en_attente }}</div>
                </div>
                <div class="stat-card en-cours">
                    <div class="label">En cours</div>
                    <div class="value">{{ $service->en_cours }}</div>
                </div>
                <div class="stat-card termine">
                    <div class="label">Terminés</div>
                    <div class="value">{{ $service->termine }}</div>
                </div>
                <div class="stat-card incomplet">
                    <div class="label">Incomplets</div>
                    <div class="value">{{ $service->incomplet }}</div>
                </div>
                <div class="stat-card absent">
                    <div class="label">Absents</div>
                    <div class="value">{{ $service->absent }}</div>
                </div>
            </div>
        </div>
    @empty
        <p class="text-muted">Aucun service configuré.</p>
    @endforelse
</div>
@endsection
