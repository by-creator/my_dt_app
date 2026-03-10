@extends('partials.app')

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
        box-shadow: 0 15px 30px rgba(0,0,0,.05);
        margin-bottom: 30px;
    }

    .guichet-title {
        font-size: 32px;
        font-weight: 700;
        color: #1e3a8a;
    }

    .client-current {
        font-size: 42px;
        font-weight: 800;
        margin: 10px 0;
        color: #1e293b;
    }

    .sub-info {
        color: #64748b;
        font-size: 16px;
    }

    .actions-bar {
        display: flex;
        justify-content: center;
        gap: 16px;
        flex-wrap: wrap;
        margin-bottom: 30px;
    }

    .actions-bar .btn {
        min-width: 130px;
        padding: 12px 20px;
        font-size: 15px;
        font-weight: 600;
        border-radius: 10px;
    }

    .panel {
        background: #fff;
        border-radius: 16px;
        padding: 25px;
        box-shadow: 0 10px 25px rgba(0,0,0,.05);
        height: 100%;
    }

    .panel h4 {
        font-size: 17px;
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

<div id="main" class="agent-wrapper">

    {{-- HEADER --}}
    <div class="main-card">
        <div class="guichet-title">Guichet N° {{ $agent->id }}</div>

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
    <div class="actions-bar">
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

                {{-- Liste temps réel des tickets en attente --}}
                <ul id="waiting-list" style="list-style:none;padding:0;margin:12px 0;max-height:220px;overflow-y:auto;">
                    @forelse($waitingTickets as $t)
                    <li data-ticket-id="{{ $t->id }}" style="display:flex;align-items:center;gap:10px;padding:6px 10px;margin-bottom:6px;background:#f1f5f9;border-radius:8px;">
                        <span style="background:#1e40af;color:#fff;border-radius:6px;padding:3px 10px;font-size:14px;font-weight:700;">{{ $t->code }}</span>
                        <span style="font-size:12px;color:#64748b;">{{ $t->created_at->format('H:i') }}</span>
                    </li>
                    @empty
                    <li id="no-waiting-msg" style="color:#64748b;font-size:14px;padding:6px 0;">Aucun client en attente</li>
                    @endforelse
                </ul>

                <p style="margin-top:12px;">Pour les clients qui ne peuvent pas scanner, cliquez sur le bouton ci-dessous :</p>

                <a href="{{ route('ticket.create') }}" target="_blank" class="ticket-btn">TICKET</a>
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

<script src="https://js.pusher.com/8.2/pusher.min.js"></script>
<script>
    window.AGENT_CONFIG = {
        agentId: {{ $agent->id }},
        serviceId: {{ $agent->service_id }},
        closeUrlTemplate: "/agent/{{ $agent->id }}/close/{ticket}/{status}",
        callUrl: "{{ route('agent.call', $agent) }}",
        rappelUrl: "{{ route('agent.rappel', $agent) }}"
    };
</script>
<script>
    document.addEventListener("DOMContentLoaded", () => {
        const csrf            = document.querySelector('meta[name="csrf-token"]').content;
        const currentClientEl = document.getElementById("current-client");
        const waitingCountEl  = document.getElementById("waiting-count");
        let currentTicketId   = currentClientEl?.dataset.ticketId || null;

        const agentId   = window.AGENT_CONFIG.agentId;
        const serviceId = window.AGENT_CONFIG.serviceId;

        const waitingListEl = document.getElementById("waiting-list");

        const refreshNoWaitingMsg = () => {
            const existing = waitingListEl.querySelector("#no-waiting-msg");
            const items = waitingListEl.querySelectorAll("li[data-ticket-id]");
            if (items.length === 0 && !existing) {
                const li = document.createElement("li");
                li.id = "no-waiting-msg";
                li.style = "color:#64748b;font-size:14px;padding:6px 0;";
                li.innerText = "Aucun client en attente";
                waitingListEl.appendChild(li);
            } else if (items.length > 0 && existing) {
                existing.remove();
            }
        };

        const pusherKey     = document.querySelector('meta[name="pusher-key"]').content;
        const pusherCluster = document.querySelector('meta[name="pusher-cluster"]').content;
        const pusher  = new Pusher(pusherKey, { cluster: pusherCluster, forceTLS: true });
        const channel = pusher.subscribe("agent." + agentId);

        channel.bind("TicketCalled", (data) => {
            if (data.agent !== agentId) return;
            currentTicketId = data.id;
            currentClientEl.innerText = data.code;
            currentClientEl.dataset.ticketId = data.id;
            // Retirer le ticket appelé de la liste
            const calledItem = waitingListEl.querySelector(`li[data-ticket-id="${data.id}"]`);
            if (calledItem) calledItem.remove();
            const newCount = Math.max(0, Number(waitingCountEl.innerText) - 1);
            if (waitingCountEl) waitingCountEl.innerText = newCount;
            refreshNoWaitingMsg();
        });

        channel.bind("TicketCreated", (data) => {
            if (data.service_id !== serviceId) return;
            // Ajouter le nouveau ticket à la liste
            const noMsg = waitingListEl.querySelector("#no-waiting-msg");
            if (noMsg) noMsg.remove();
            const li = document.createElement("li");
            li.dataset.ticketId = data.id;
            li.style = "display:flex;align-items:center;gap:10px;padding:6px 10px;margin-bottom:6px;background:#f1f5f9;border-radius:8px;";
            const now = new Date();
            const hhmm = now.getHours().toString().padStart(2,"0") + ":" + now.getMinutes().toString().padStart(2,"0");
            li.innerHTML = `<span style="background:#1e40af;color:#fff;border-radius:6px;padding:3px 10px;font-size:14px;font-weight:700;">${data.code}</span><span style="font-size:12px;color:#64748b;">${hhmm}</span>`;
            waitingListEl.appendChild(li);
            if (waitingCountEl) waitingCountEl.innerText = Number(waitingCountEl.innerText) + 1;
        });

        channel.bind("TicketClosed", (data) => {
            if (!currentTicketId || data.ticket_id !== Number(currentTicketId)) return;
            currentTicketId = null;
            currentClientEl.innerText = "—";
            currentClientEl.dataset.ticketId = "";
        });

        // Polling de synchronisation toutes les 30s (filet de sécurité)
        const waitingUrl = `/agent/${agentId}/waiting`;
        const syncWaitingList = () => {
            fetch(waitingUrl, { headers: { Accept: "application/json" } })
                .then(r => r.json())
                .then(tickets => {
                    // Reconstruit la liste complète
                    waitingListEl.innerHTML = "";
                    if (tickets.length === 0) {
                        const li = document.createElement("li");
                        li.id = "no-waiting-msg";
                        li.style = "color:#64748b;font-size:14px;padding:6px 0;";
                        li.innerText = "Aucun client en attente";
                        waitingListEl.appendChild(li);
                    } else {
                        tickets.forEach(t => {
                            const li = document.createElement("li");
                            li.dataset.ticketId = t.id;
                            li.style = "display:flex;align-items:center;gap:10px;padding:6px 10px;margin-bottom:6px;background:#f1f5f9;border-radius:8px;";
                            const hhmm = t.created_at ? t.created_at.substring(11,16) : "";
                            li.innerHTML = `<span style="background:#1e40af;color:#fff;border-radius:6px;padding:3px 10px;font-size:14px;font-weight:700;">${t.code}</span><span style="font-size:12px;color:#64748b;">${hhmm}</span>`;
                            waitingListEl.appendChild(li);
                        });
                    }
                    if (waitingCountEl) waitingCountEl.innerText = tickets.length;
                })
                .catch(err => console.warn("Sync waiting list failed", err));
        };
        setInterval(syncWaitingList, 30000);

        document.addEventListener("click", (e) => {
            const button = e.target.closest(".agent-action");
            if (!button) return;
            const action = button.dataset.action;
            let url = null;
            switch (action) {
                case "call":    url = window.AGENT_CONFIG.callUrl; break;
                case "rappel":
                    if (!currentTicketId) { alert("Aucun ticket en cours"); return; }
                    url = window.AGENT_CONFIG.rappelUrl; break;
                case "termine": case "incomplet": case "absent":
                    if (!currentTicketId) { alert("Aucun ticket en cours"); return; }
                    url = window.AGENT_CONFIG.closeUrlTemplate
                        .replace("{ticket}", currentTicketId).replace("{status}", action); break;
                default: return;
            }
            fetch(url, { method: "POST", headers: { "X-CSRF-TOKEN": csrf, Accept: "application/json" } })
                .then(r => r.json())
                .then(d => {
                    if (action === "call" && d.ticket_id && d.code) {
                        // Mise à jour immédiate de l'UI sans attendre Pusher
                        currentTicketId = d.ticket_id;
                        currentClientEl.innerText = d.code;
                        currentClientEl.dataset.ticketId = d.ticket_id;
                        // Retirer le ticket appelé de la liste d'attente
                        const calledItem = waitingListEl.querySelector(`li[data-ticket-id="${d.ticket_id}"]`);
                        if (calledItem) calledItem.remove();
                        const newCount = Math.max(0, Number(waitingCountEl.innerText) - 1);
                        if (waitingCountEl) waitingCountEl.innerText = newCount;
                        refreshNoWaitingMsg();
                    } else if ((action === "termine" || action === "incomplet" || action === "absent")) {
                        // Réinitialiser l'affichage client en cours
                        currentTicketId = null;
                        currentClientEl.innerText = "—";
                        currentClientEl.dataset.ticketId = "";
                    }
                })
                .catch(err => console.error("❌", action, err));
        });
    });
</script>

@endsection
