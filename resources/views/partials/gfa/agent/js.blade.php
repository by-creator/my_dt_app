<script>
document.addEventListener('DOMContentLoaded', function () {

    const formSuivant = document.getElementById('form-suivant');
    if (!formSuivant) return;

    formSuivant.addEventListener('submit', function (e) {

        const button = formSuivant.querySelector('button');

        const hasNext    = button.dataset.hasNext === '1';
        const hasCurrent = button.dataset.hasCurrent === '1';

        // ❌ Ticket en cours
        if (hasCurrent) {
            e.preventDefault();

            Swal.fire({
                icon: 'warning',
                title: 'Traitement en cours',
                text: 'Veuillez terminer le ticket en cours avant d’appeler le suivant.',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-primary'
                }
            });
            return;
        }

        // ❌ Aucun client en attente
        if (!hasNext) {
            e.preventDefault();

            Swal.fire({
                icon: 'info',
                title: 'Aucun client en attente',
                text: 'Il n’y a actuellement aucun ticket à appeler.',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-primary'
                }
            });
            return;
        }

        // ✅ OK → submit
    });
});
</script>


<script>
document.addEventListener('DOMContentLoaded', function () {

    const formRappel = document.getElementById('form-rappel');

    if (!formRappel) {
        console.warn('form-rappel introuvable');
        return;
    }

    formRappel.addEventListener('submit', function (e) {

        console.log('clic rappel détecté');

        const button = formRappel.querySelector('button');
        const hasTicket = button.dataset.hasTicket === '1';

        // ❌ Aucun ticket
        if (!hasTicket) {
            e.preventDefault();

            Swal.fire({
                icon: 'info',
                title: 'Aucun client à rappeler',
                text: 'Veuillez appeler un client avant d’effectuer un rappel.',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-primary'
                }
            });

            return;
        }

        // 🔁 Confirmation
        e.preventDefault();

        Swal.fire({
            title: 'Rappeler le client ?',
            text: 'Le même client sera rappelé au guichet.',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Oui, rappeler',
            cancelButtonText: 'Annuler',
            buttonsStyling: false,
            customClass: {
                confirmButton: 'btn btn-secondary me-2',
                cancelButton: 'btn btn-light'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                formRappel.submit();
            }
        });

    });

});
</script>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('form-terminer');

        if (!form) return;

        form.addEventListener('submit', function(e) {
            const hasTicket = form.querySelector('button')
                .dataset.hasTicket === '1';

            if (!hasTicket) {
                e.preventDefault();

                Swal.fire({
                    icon: 'info',
                    title: 'Aucun ticket en cours',
                    text: 'Veuillez appeler un client avant de terminer.',
                    confirmButtonText: 'OK',
                    buttonsStyling: false,
                    customClass: {
                        confirmButton: 'btn btn-primary'
                    }
                });
            }
        });
    });
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('form-incomplet');

    if (!form) return;

    form.addEventListener('submit', function (e) {
        const hasTicket = form.querySelector('button')
            .dataset.hasTicket === '1';

        if (!hasTicket) {
            e.preventDefault();

            Swal.fire({
                icon: 'info',
                title: 'Aucun ticket en cours',
                text: 'Veuillez appeler un client avant de marquer le dossier incomplet.',
                confirmButtonText: 'OK',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-primary'
                }
            });
        }
    });
});
</script>


<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('form-absent');

    if (!form) return;

    form.addEventListener('submit', function (e) {
        const hasTicket = form.querySelector('button')
            .dataset.hasTicket === '1';

        if (!hasTicket) {
            e.preventDefault();

            Swal.fire({
                icon: 'info',
                title: 'Aucun ticket en cours',
                text: 'Veuillez appeler un client avant de marquer le client absent.',
                confirmButtonText: 'OK',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-primary'
                }
            });
        }
    });
});
</script>




