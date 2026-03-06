import Pusher from "pusher-js";

window.PusherInstance = () => {
    const metaKey     = document.querySelector('meta[name="pusher-key"]');
    const metaCluster = document.querySelector('meta[name="pusher-cluster"]');

    if (!metaKey || !metaKey.content) {
        console.error("❌ Pusher key introuvable");
        throw new Error("Pusher key missing");
    }

    console.log("🟢 Pusher key détectée :", metaKey.content);

    return new Pusher(metaKey.content, {
        cluster: metaCluster?.content || "mt1",
        forceTLS: true,
    });
};
