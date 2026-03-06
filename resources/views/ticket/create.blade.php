@extends('layouts.app')

@section('content')

<style>
    body {
        margin: 0;
        background: #f5f7fb;
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
    }

    .ticket-page {
        min-height: 100vh;
        padding: 40px 20px;
        text-align: center;
        position: relative;
    }

    .ticket-page h1 {
        font-size: 34px;
        font-weight: 700;
        margin-bottom: 50px;
        color: #1e293b;
    }

    .ticket-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 25px;
        max-width: 700px;
        margin: 0 auto;
    }

    .ticket-card {
        background: white;
        border-radius: 20px;
        padding: 45px 30px;
        cursor: pointer;
        transition: all .25s ease;
        border: 1px solid #e5e7eb;
        box-shadow: 0 10px 25px rgba(0, 0, 0, .05);
        display: flex;
        align-items: center;
        gap: 25px;
    }

    .ticket-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, .08);
        border-color: #6366f1;
    }

    .icon {
        width: 75px;
        height: 75px;
        background: #6366f1;
        color: white;
        border-radius: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 36px;
        flex-shrink: 0;
    }

    .ticket-title {
        text-align: left;
        font-size: 18px;
        color: #475569;
    }

    .ticket-title strong {
        display: block;
        font-size: 24px;
        margin-top: 5px;
        color: #0f172a;
    }

    .ticket-card form {
        display: none;
    }

    #overlay {
        position: fixed;
        inset: 0;
        background: rgba(255,255,255,0.95);
        z-index: 9999;
        display: none;
        justify-content: center;
        align-items: center;
        flex-direction: column;
        font-size: 20px;
        font-weight: 600;
        color: #1e293b;
    }

    .spinner {
        width: 40px;
        height: 40px;
        border: 4px solid #e5e7eb;
        border-top: 4px solid #6366f1;
        border-radius: 50%;
        animation: spin 1s linear infinite;
        margin-bottom: 15px;
    }

    @keyframes spin {
        to { transform: rotate(360deg); }
    }

    @media (max-width: 600px) {
        .ticket-card { padding: 35px 20px; }
        .icon { width: 60px; height: 60px; font-size: 28px; }
        .ticket-title strong { font-size: 20px; }
    }
</style>

<div class="ticket-page" id="ticketPage">
    <h1>Choisissez un ticket</h1>

    <div class="ticket-grid">
        @foreach ($services as $service)
            <div class="ticket-card" onclick="openTicket(this)">
                <div class="icon">
                    @switch(strtolower($service->name))
                        @case('validation') 📄 @break
                        @case('facturation') 💳 @break
                        @case('caisse') 💰 @break
                        @default 📦 @break
                    @endswitch
                </div>

                <div class="ticket-title">
                    Ticket pour
                    <strong>{{ $service->name }}</strong>
                </div>

                <form method="POST" action="{{ route('ticket.store') }}">
                    @csrf
                    <input type="hidden" name="service_id" value="{{ $service->id }}">
                    <input type="hidden" name="token" value="{{ $formToken }}">
                </form>
            </div>
        @endforeach
    </div>
</div>

<div id="overlay">
    <div class="spinner"></div>
    Votre ticket est en cours de création...
</div>

<script>
let ticketClicked = false;

function openTicket(card) {
    if (ticketClicked) return;
    ticketClicked = true;

    const form = card.querySelector('form');

    document.getElementById('overlay').style.display = 'flex';
    document.getElementById('ticketPage').style.pointerEvents = 'none';

    document.querySelectorAll('.ticket-card').forEach(el => {
        el.style.opacity = '0.6';
        el.style.pointerEvents = 'none';
    });

    form.submit();
}

window.history.pushState(null, null, window.location.href);
window.addEventListener('popstate', function () {
    window.history.go(1);
});
</script>

@endsection
