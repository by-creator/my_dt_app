{{-- Bloc ticket --}}
<div class="card card-main mb-4 d-flex justify-content-center align-items-center text-center" style="min-height: 250px;">

    <div>
        <h2 class="mb-3">Guichet N° {{ $guichet->id }}</h2>

        {{-- Ticket en cours --}}
        @if ($ticketEnCours)
            <div class="ticket mb-4">
                <h1>Client en cours : {{ $ticketEnCours->numero }}</h1>
            </div>
        @else
            <div class="text-muted mb-4">
                <h1>Aucun client en cours</h1>
            </div>
        @endif

        {{-- Tickets en attente --}}
        @if ($ticketsEnAttente->count())
            <ul class="list-group mt-3">
                @foreach ($ticketsEnAttente as $ticket)
                    <li class="list-group-item d-flex justify-content-between">
                        <span>Client N° {{ $ticket->numero }}</span>
                        <span class="badge bg-warning">En attente</span>
                    </li>
                @endforeach
            </ul>
        @else
            <p class="text-muted mt-3">Aucun client en attente</p>
        @endif

    </div>
</div>

{{-- Boutons actions --}}
<div class="row text-center mb-4">
    <div class="col">
        <form id="form-suivant" method="POST" action="{{ route('agent.guichet.appeler', $guichet) }}">
            @csrf

            <button type="submit" class="btn btn-primary btn-action"
                data-has-next="{{ $enAttenteCount > 0 ? '1' : '0' }}"
                data-has-current="{{ $ticketEnCours ? '1' : '0' }}">
                Suivant
            </button>

        </form>
    </div>


    <div class="col">
        <form id="form-rappel" method="POST"
            action="{{ $ticketEnCours ? route('agent.ticket.rappel', $ticketEnCours) : '#' }}">
            @csrf

            <button type="submit" class="btn btn-secondary btn-action"
                data-has-ticket="{{ $ticketEnCours ? '1' : '0' }}">
                Rappel
            </button>
        </form>
    </div>


    <div class="col">
        <form id="form-incomplet" method="POST"
            action="{{ $ticketEnCours ? route('agent.ticket.incomplet', $ticketEnCours) : '#' }}">
            @csrf
            <button type="submit" class="btn btn-warning btn-action"
                data-has-ticket="{{ $ticketEnCours ? '1' : '0' }}">
                Incomplet
            </button>
        </form>

    </div>

    <div class="col">
        <form id="form-terminer" method="POST"
            action="{{ $ticketEnCours ? route('agent.ticket.terminer', $ticketEnCours) : '#' }}">
            @csrf

            <button type="submit" class="btn btn-success btn-action"
                data-has-ticket="{{ $ticketEnCours ? '1' : '0' }}">
                Terminé
            </button>
        </form>
    </div>



    <div class="col">
        <form id="form-absent" method="POST"
            action="{{ $ticketEnCours ? route('agent.ticket.absent', $ticketEnCours) : '#' }}">
            @csrf
            <button type="submit" class="btn btn-danger btn-action"
                data-has-ticket="{{ $ticketEnCours ? '1' : '0' }}">
                Absent
            </button>
        </form>

    </div>
</div>

{{-- Infos bas --}}
<div class="row">
    <div class="col-md-6">
        <div class="card p-3">
            <h5>CLIENT(S) EN ATTENTE : {{ $enAttenteCount }}</h5>

            <ul class="nav nav-tabs mt-3">
                <li class="nav-item">
                    <a class="nav-link active">Client</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link">Personnel</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link">Rapports</a>
                </li>
            </ul>

            <div class="mt-3">
                <p>Pour les clients qui ne peuvent pas scanner cliquez sur le bouton ci-dessous :</p>
                <a href=" {{ route('ticket.create') }}" target="_blank" rel="noopener noreferrer">
                    <button class="btn btn-primary">TICKET</button>
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card p-3">
            <h5>Guide d'utilisation</h5>

            <ul class="mt-3">
                <li><strong>Suivant</strong> : appeler le prochain client</li>
                <li><strong>Rappel</strong> : rappeler le client</li>
                <li><strong>Incomplet</strong> : dossier incomplet</li>
                <li><strong>Terminé</strong> : traitement terminé</li>
                <li><strong>Absent</strong> : client absent</li>
            </ul>
        </div>
    </div>
</div>

@include('partials.gfa.agent.js')
