<script>
/**
 * === DISPLAY AUDIO (VERSION STABLE) ===
 */

let audioEnabled = localStorage.getItem('audioEnabled') === 'true';

function enableAudio() {
    audioEnabled = true;
    localStorage.setItem('audioEnabled', 'true');

    new Audio('/sonnerie.mp3').play().catch(() => {});
    speechSynthesis.resume();

    alert('🔊 Annonces activées');
}

function jouerAnnonce(numero, guichet) {
    const audio = new Audio('/sonnerie.mp3');

    audio.play().catch(() => {});

    audio.onended = () => {
        setTimeout(() => {
            const speech = new SpeechSynthesisUtterance(
                `Le ticket numéro ${numero} est attendu au guichet numéro ${guichet}`
            );
            speech.lang = 'fr-FR';
            speech.rate = 0.8;
            speech.pitch = 1.0;

            speechSynthesis.cancel();
            speechSynthesis.speak(speech);
        }, 300);
    };
}

document.addEventListener('DOMContentLoaded', function () {

    const currentTicket  = window.currentTicket;
    const currentGuichet = window.currentGuichet;
    const currentCallAt  = window.currentCallAt;

    const lastCallAt = localStorage.getItem('lastCallAt');

    if (
        audioEnabled &&
        currentTicket &&
        currentCallAt &&
        lastCallAt !== currentCallAt
    ) {
        jouerAnnonce(currentTicket, currentGuichet);
        localStorage.setItem('lastCallAt', currentCallAt);
    }

    if (!lastCallAt && currentCallAt) {
        localStorage.setItem('lastCallAt', currentCallAt);
    }

});
</script>
