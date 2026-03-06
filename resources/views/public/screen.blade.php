<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Écran d'appel clients</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="pusher-key" content="{{ config('broadcasting.connections.pusher.key') }}">
    <meta name="pusher-cluster" content="{{ config('broadcasting.connections.pusher.options.cluster') }}">
    <script src="/js/qrcode.min.js"></script>
    <style>
        * { box-sizing: border-box; }
        html, body { height: 100%; margin: 0; font-family: "Segoe UI", Arial, sans-serif; }

        .screen {
            height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            background: #f5f7fb;
        }

        .call-wrapper {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .call-card {
            background: #ffffff;
            border-radius: 24px;
            padding: 60px 80px;
            text-align: center;
            box-shadow: 0 25px 50px rgba(0,0,0,0.08);
            min-width: 60%;
        }

        .agent-line {
            font-size: 36px;
            font-weight: 700;
            color: #1e40af;
            margin-bottom: 18px;
        }

        .client-line {
            font-size: 64px;
            font-weight: 800;
            color: #020617;
        }

        .footer {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            padding: 30px;
        }

        .info-card {
            background: #ffffff;
            border-radius: 16px;
            padding: 25px;
            display: flex;
            gap: 20px;
            align-items: center;
            box-shadow: 0 10px 25px rgba(0,0,0,.06);
        }

        #qr-wifi, #qr-ticket {
            width: 130px;
            height: 130px;
            flex-shrink: 0;
        }

        .info-text h4 { margin: 0 0 10px 0; font-size: 18px; }
        .info-text p  { margin: 0; color: #64748b; font-size: 15px; }

        /* Audio overlay */
        .audio-overlay {
            position: fixed;
            inset: 0;
            background: rgba(15,23,42,0.75);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
        }

        .audio-overlay.hidden { display: none; }

        .audio-modal {
            background: #ffffff;
            padding: 30px 35px;
            border-radius: 16px;
            max-width: 420px;
            text-align: center;
            box-shadow: 0 20px 40px rgba(0,0,0,0.25);
        }

        .audio-modal h3 { margin-bottom: 10px; font-size: 22px; color: #1e293b; }
        .audio-modal p  { font-size: 15px; color: #475569; margin-bottom: 20px; }

        .btn-primary {
            background: #2563eb;
            color: #fff;
            border: none;
            padding: 12px 22px;
            border-radius: 10px;
            font-size: 16px;
            cursor: pointer;
        }

        .btn-primary:hover { background: #1d4ed8; }

        @media (max-width: 900px) {
            .call-card { padding: 40px; min-width: 90%; }
            .client-line { font-size: 48px; }
        }
    </style>
</head>
<body>

    <div id="audio-overlay" class="audio-overlay">
        <div class="audio-modal">
            <h3>🔊 Activer le son</h3>
            <p>Pour entendre l'annonce vocale et la sonnerie, veuillez activer le son.</p>
            <button id="enable-sound" class="btn-primary">▶️ Activer le son</button>
        </div>
    </div>

    <div class="screen">

        <div class="call-wrapper">
            <div class="call-card">
                <div id="agent-line" class="agent-line">Agent —</div>
                <div id="client-line" class="client-line">Client —</div>
            </div>
        </div>

        <div class="footer">
            <div class="info-card">
                <div id="qr-wifi"></div>
                <div class="info-text">
                    <h4>Code QR pour se connecter au réseau WI-FI</h4>
                    <p>Étape 1 : Connexion à internet</p>
                </div>
            </div>

            <div class="info-card">
                <div id="qr-ticket"></div>
                <div class="info-text">
                    <h4>Code QR pour prendre un ticket</h4>
                    <p>Étape 2 : Choix du ticket</p>
                </div>
            </div>
        </div>

    </div>

    <audio id="ding" src="/ding.mp3" preload="auto"></audio>

    <script src="https://js.pusher.com/8.2/pusher.min.js"></script>
    <script>
        let audioUnlocked  = false;
        let speechUnlocked = false;

        document.addEventListener("DOMContentLoaded", () => {
            const agentLine  = document.getElementById("agent-line");
            const clientLine = document.getElementById("client-line");
            const audio      = document.getElementById("ding");
            const overlay    = document.getElementById("audio-overlay");
            const enableBtn  = document.getElementById("enable-sound");

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

            const pusherKey     = document.querySelector('meta[name="pusher-key"]').content;
            const pusherCluster = document.querySelector('meta[name="pusher-cluster"]').content;
            const pusher  = new Pusher(pusherKey, { cluster: pusherCluster, forceTLS: true });
            const channel = pusher.subscribe("tickets");

            channel.bind("TicketCalled", (data) => {
                agentLine.innerText  = `Agent — Guichet ${data.agent}`;
                clientLine.innerText = `Client — ${data.code}`;
                playDingThenSpeak(`Le client ${data.code.replace("-", " ")}. Veuillez vous présenter au guichet ${data.agent}.`);
            });

            channel.bind("TicketClosed", () => {
                agentLine.innerText  = "Agent —";
                clientLine.innerText = "Client —";
            });

            enableBtn?.addEventListener("click", () => {
                audio.play().then(() => {
                    audio.pause(); audio.currentTime = 0;
                    audioUnlocked = true; speechUnlocked = true;
                    overlay?.classList.add("hidden");
                    enableBtn.disabled = true;
                }).catch(err => console.warn("🔴 Déblocage audio refusé", err));
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const WIFI_SSID     = "DTLBOX23";
            const WIFI_PASSWORD = "P@sser=123";
            const WIFI_TYPE     = "WPA";

            new QRCode(document.getElementById("qr-wifi"), {
                text: `WIFI:T:${WIFI_TYPE};S:${WIFI_SSID};P:${WIFI_PASSWORD};;`,
                width: 130, height: 130, correctLevel: QRCode.CorrectLevel.H
            });

            new QRCode(document.getElementById("qr-ticket"), {
                text: "{{ route('ticket.scan') }}",
                width: 130, height: 130, correctLevel: QRCode.CorrectLevel.H
            });
        });
    </script>

</body>
</html>
