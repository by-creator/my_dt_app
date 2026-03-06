import "./pusher";

document.addEventListener("DOMContentLoaded", () => {
    console.log("🟢 [AGENT] Dashboard ready");

    const csrfMeta = document.querySelector('meta[name="csrf-token"]');
    if (!csrfMeta) {
        console.error("❌ CSRF token introuvable");
        return;
    }
    const csrf = csrfMeta.content;

    const currentClientEl  = document.getElementById("current-client");
    const waitingCountEl   = document.getElementById("waiting-count");

    let currentTicketId = currentClientEl?.dataset.ticketId || null;

    const agentId   = window.AGENT_CONFIG.agentId;
    const serviceId = window.AGENT_CONFIG.serviceId;

    const pusher  = window.PusherInstance();
    const channel = pusher.subscribe(`agent.${agentId}`);

    /* --- TICKET APPELÉ --- */
    channel.bind("TicketCalled", (data) => {
        console.log("📣 [AGENT] TicketCalled", data);

        if (data.agent_id !== agentId) return;

        currentTicketId = data.id;
        currentClientEl.innerText = data.code;
        currentClientEl.dataset.ticketId = data.id;

        if (waitingCountEl) {
            waitingCountEl.innerText = Math.max(0, Number(waitingCountEl.innerText) - 1);
        }
    });

    /* --- NOUVEAU TICKET EN ATTENTE --- */
    channel.bind("TicketCreated", (data) => {
        console.log("🎟️ TicketCreated", data);

        if (data.service_id !== serviceId) return;

        if (waitingCountEl) {
            waitingCountEl.innerText = Number(waitingCountEl.innerText) + 1;
        }
    });

    /* --- TICKET CLÔTURÉ --- */
    channel.bind("TicketClosed", (data) => {
        console.log("✅ TicketClosed", data);

        if (!currentTicketId || data.ticket_id !== Number(currentTicketId)) return;

        currentTicketId = null;
        currentClientEl.innerText = "—";
        currentClientEl.dataset.ticketId = "";
    });

    /* --- ACTIONS AGENT --- */
    document.addEventListener("click", (e) => {
        const button = e.target.closest(".agent-action");
        if (!button) return;

        const action = button.dataset.action;
        let url = null;

        switch (action) {
            case "call":
                url = window.AGENT_CONFIG.callUrl;
                break;

            case "rappel":
                if (!currentTicketId) { alert("Aucun ticket en cours"); return; }
                url = window.AGENT_CONFIG.rappelUrl;
                break;

            case "termine":
            case "incomplet":
            case "absent":
                if (!currentTicketId) { alert("Aucun ticket en cours"); return; }
                url = window.AGENT_CONFIG.closeUrlTemplate
                    .replace("{ticket}", currentTicketId)
                    .replace("{status}", action);
                break;

            default:
                console.warn("❌ Action inconnue");
                return;
        }

        fetch(url, {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": csrf,
                Accept: "application/json",
            },
        })
            .then((res) => res.json())
            .then((data) => console.log(`🟢 [AGENT] ${action} OK`, data))
            .catch((err) => console.error(`🔴 [AGENT] ${action} ERROR`, err));
    });
});
