@extends('layouts.app')

@section('content')
<style>
    body { background: #f5f7fb; }

    .ticket-container {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }

    .ticket-card {
        background: #ffffff;
        border-radius: 24px;
        padding: 50px 40px;
        max-width: 500px;
        width: 100%;
        text-align: center;
        box-shadow: 0 20px 45px rgba(0,0,0,.08);
    }

    .ticket-title {
        font-size: 28px;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 25px;
    }

    .ticket-number {
        font-size: 96px;
        font-weight: 800;
        color: #1e40af;
        margin: 30px 0;
        letter-spacing: 3px;
    }

    .ticket-info {
        font-size: 16px;
        color: #64748b;
        margin-bottom: 30px;
    }

    @media (max-width: 480px) {
        .ticket-number { font-size: 72px; }
    }
</style>

<div class="ticket-container">
    <div class="ticket-card">
        <div class="ticket-title">🎟️ Votre ticket</div>

        <div class="ticket-number">
            {{ $ticket->code }}
        </div>

        <div class="ticket-info">
            Merci de patienter.<br>
            Votre numéro sera appelé à l'écran.
        </div>
    </div>
</div>

<script>
window.history.pushState(null, null, window.location.href);
window.onpopstate = function () {
    window.location.replace("{{ route('ticket.create') }}");
};
</script>
@endsection
