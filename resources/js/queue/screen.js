import Ably from "ably";

let audioUnlocked   = false;
let speechUnlocked  = false;

document.addEventListener("DOMContentLoaded", () => {
    console.log("🟢 [SCREEN] Ready");

    const agentLine = document.getElementById("agent-line");
    const clientLine = document.getElementById("client-line");
    const audio     = document.getElementById("ding");
    const overlay   = document.getElementById("audio-overlay");
    const enableBtn = document.getElementById("enable-sound");

    const playDingThenSpeak = (text) => {
        if (!audioUnlocked) return;
        if ("speechSynthesis" in window) speechSynthesis.cancel();
        audio.currentTime = 0;

        audio.onended = () => {
            if (!speechUnlocked || !("speechSynthesis" in window)) return;
            const msg = new SpeechSynthesisUtterance(text);
            msg.lang = "fr-FR"; msg.rate = 0.85; msg.pitch = 1.0; msg.volume = 1.0;
            const voices = speechSynthesis.getVoices();
            const frVoice = voices.find(v => v.lang === "fr-FR" && v.name.toLowerCase().includes("female"))
                         || voices.find(v => v.lang === "fr-FR");
            if (frVoice) msg.voice = frVoice;
            speechSynthesis.speak(msg);
        };

        audio.play().catch(err => console.warn("🔴 Ding bloqué", err));
    };

    /* ── Ably ──────────────────────────────────────────────────── */
    const ablyKey = document.querySelector('meta[name="ably-key"]')?.content;
    const client  = new Ably.Realtime({ key: ablyKey });
    const channel = client.channels.get("tickets");

    channel.subscribe("TicketCalled", (msg) => {
        const data = msg.data;
        console.log("📣 TicketCalled", data);
        agentLine.innerText  = `Agent — Guichet ${data.agent}`;
        clientLine.innerText = `Client — ${data.code}`;
        const readableCode = data.code.replace("-", " ");
        playDingThenSpeak(`Le client ${readableCode}. Veuillez vous présenter au guichet ${data.agent}.`);
    });

    channel.subscribe("TicketClosed", () => {
        agentLine.innerText  = "Agent —";
        clientLine.innerText = "Client —";
    });

    /* ── Déblocage audio ──────────────────────────────────────── */
    enableBtn?.addEventListener("click", () => {
        audio.play().then(() => {
            audio.pause();
            audio.currentTime = 0;
            audioUnlocked  = true;
            speechUnlocked = true;
            overlay?.classList.add("hidden");
            enableBtn.disabled = true;
        }).catch(err => console.warn("🔴 Déblocage audio refusé", err));
    });
});
