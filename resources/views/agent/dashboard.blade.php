@extends('layouts.agent')

@section('content')
    <style>
        .agent-wrapper {
            background: #f5f7fb;
            padding: 30px;
            min-height: 100vh;
        }

        .main-card {
            background: #fff;
            border-radius: 20px;
            padding: 40px;
            text-align: center;
            box-shadow: 0 15px 30px rgba(0, 0, 0, .05);
            margin-bottom: 30px;
        }

        .guichet {
            font-size: 36px;
            font-weight: 700;
            color: #1e3a8a;
        }

        .client-current {
            font-size: 44px;
            font-weight: 800;
            margin: 10px 0;
            color: #1e293b;
        }

        .sub-info {
            color: #64748b;
            font-size: 16px;
        }

        .panel {
            background: #fff;
            border-radius: 16px;
            padding: 25px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, .05);
            height: 100%;
        }

        .panel h4 {
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 15px;
            color: #1e293b;
        }

        .tabs {
            display: flex;
            gap: 20px;
            margin-bottom: 15px;
            border-bottom: 1px solid #e5e7eb;
        }

        .tabs span {
            padding-bottom: 8px;
            cursor: pointer;
            font-weight: 600;
            color: #64748b;
        }

        .tabs span.active {
            color: #1e40af;
            border-bottom: 3px solid #1e40af;
        }

        .ticket-btn {
            background: #4f46e5;
            color: white;
            padding: 10px 18px;
            border-radius: 8px;
            display: inline-block;
            margin-top: 10px;
            font-weight: 600;
            text-decoration: none;
        }
    </style>

    <div class="agent-wrapper">

        {{-- HEADER --}}
        <div class="main-card">
            <div class="guichet">Guichet N° {{ $agent->id }}</div>

            <div class="client-current">
                Client en cours :
                <span id="current-client" data-ticket-id="{{ $currentTicket?->id }}">
                    {{ $currentTicket?->code ?? '—' }}
                </span>
            </div>

            <div class="sub-info">
                {{ $waitingTickets->count() === 0 ? 'Aucun client en attente' : '' }}
            </div>
        </div>

        {{-- ACTIONS --}}
        <div class="d-flex gap-3 flex-wrap mb-4">
            <button type="button" class="btn btn-primary agent-action" data-action="call">
                📣 Suivant
            </button>
            <button type="button" class="btn btn-secondary agent-action" data-action="rappel">
                🔁 Rappel
            </button>
            <button type="button" class="btn btn-success agent-action" data-action="termine">
                ✅ Terminé
            </button>
            <button type="button" class="btn btn-warning text-white agent-action" data-action="incomplet">
                ⚠️ Incomplet
            </button>
            <button type="button" class="btn btn-danger agent-action" data-action="absent">
                🚫 Absent
            </button>
        </div>

        {{-- PANELS --}}
        <div class="row">
            <div class="col-md-6 mb-3">
                <div class="panel">
                    <h4>
                        CLIENT(S) EN ATTENTE :
                        <span id="waiting-count">{{ $waitingTickets->count() }}</span>
                    </h4>

                    <div class="tabs">
                        <span class="active">Client</span>
                        <span>Personnel</span>
                        <span>Rapports</span>
                    </div>

                    <p>
                        Pour les clients qui ne peuvent pas scanner,
                        cliquez sur le bouton ci-dessous :
                    </p>

                    <a href="{{ route('ticket.create') }}" target="_blank" class="ticket-btn">
                        TICKET
                    </a>
                </div>
            </div>

            <div class="col-md-6 mb-3">
                <div class="panel">
                    <h4>Guide d'utilisation</h4>
                    <ul>
                        <li><strong>Suivant</strong> : appeler le prochain client</li>
                        <li><strong>Rappel</strong> : rappeler le client</li>
                        <li><strong>Incomplet</strong> : dossier incomplet</li>
                        <li><strong>Terminé</strong> : traitement terminé</li>
                        <li><strong>Absent</strong> : client absent</li>
                    </ul>
                </div>
            </div>
        </div>

    </div>

    @vite('resources/js/agent.js')

    <script>
        window.AGENT_CONFIG = {
            agentId: {{ $agent->id }},
            serviceId: {{ $agent->service_id }},
            closeUrlTemplate: "/agent/{{ $agent->id }}/close/{ticket}/{status}",
            callUrl: "{{ route('agent.call', $agent) }}",
            rappelUrl: "{{ route('agent.rappel', $agent) }}"
        };
    </script>
@endsection
