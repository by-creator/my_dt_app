@extends('display.layout')

@section('content')
    {{-- Bouton audio --}}
    <button class="btn btn-light mb-4" onclick="enableAudio()">
        🔊
    </button>

    {{-- Bloc principal --}}
    <div class="card-main mb-4">
        @if ($tickets->count())
            @php $ticket = $tickets->first(); @endphp

            <div class="ticket">
                Guichet N° {{ $ticket->guichet->nom }}
            </div>

            <div class="ticket">
                Client N° {{ $ticket->numero }}
            </div>

            <script>
                window.currentTicket = @json($ticket->numero ?? null);
                window.currentGuichet = @json($ticket->guichet->nom ?? null);
                window.currentCallAt = @json($ticket->appel_at ?? null);
            </script>
        @else
            <div class="ticket">Aucun ticket appelé</div>
            <script>
                window.currentTicket = null;
            </script>
        @endif
    </div>

    {{-- QR Codes --}}
    <div class="row g-4">
        <div class="col-md-6">
            <div class="card-qr">
                <h5>Code QR pour se connecter au réseau WI-FI</h5>

                <div class="d-flex align-items-center gap-4">
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=160x160&data={{ urlencode($wifiQr) }}"
                        alt="QR WiFi">

                    <div>
                        <strong>← Étape 1 :</strong> Connexion à internet<br>
                        Scannez ce code pour vous connecter automatiquement au WI-FI
                    </div>
                </div>
            </div>
        </div>


        <div class="col-md-6">
            <div class="card-qr">
                <h5>Code QR pour prendre un ticket</h5>

                <div class="d-flex align-items-center gap-4">
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=160x160&data={{ urlencode($ticketUrl) }}"
                        alt="QR Ticket">

                    <div>
                        <strong>← Étape 2 :</strong> Choix du ticket<br>
                        Scannez ce code afin de faire le choix d'un ticket en fonction de votre besoin
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Script son + voix --}}
    @include('display.audio')
@endsection
