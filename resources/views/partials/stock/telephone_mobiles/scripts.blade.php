<script>
document.addEventListener("DOMContentLoaded", function () {

    /**
     * ============================
     * ✏️ MODIFIER (PUT)
     * ============================
     */
    document.addEventListener('click', function (e) {

        const btn = e.target.closest('.btn-edit');
        if (!btn) return;

        const id = btn.dataset.id;

        const setVal = (id, value) => {
            const el = document.getElementById(id);
            if (el) el.value = value ?? '';
        };

        // Remplissage des champs
        setVal('editMatricule', btn.dataset.matricule);
        setVal('editNom', btn.dataset.nom);
        setVal('editPrenom', btn.dataset.prenom);
        setVal('editService', btn.dataset.service);
        setVal('editDestination', btn.dataset.destination);
        setVal('editReference', btn.dataset.reference_telephone);
        setVal('editAncienForfait', btn.dataset.montant_ancien_forfait_ttc);
        setVal('editNumeroSim', btn.dataset.numero_sim);
        setVal('editFormulePremium', btn.dataset.formule_premium);
        setVal('editForfait', btn.dataset.montant_forfait_ttc);
        setVal('editCodePuk', btn.dataset.code_puk);
        setVal('editStatut', btn.dataset.statut);
        setVal('editCause', btn.dataset.cause_changement);
        setVal('editImsi', btn.dataset.imsi);

        // Date (format HTML5 YYYY-MM-DD)
        if (btn.dataset.acquisition_date) {
            setVal(
                'editAcquisitionDate',
                btn.dataset.acquisition_date.substring(0, 10)
            );
        }

        // ✅ ACTION DU FORM (PUT avec ID)
        document.getElementById('editForm').action =
            "{{ route('telephone-mobiles.update', ':id') }}"
                .replace(':id', id);
    });

    /**
     * ============================
     * 🗑️ SUPPRIMER (DELETE)
     * ============================
     */
    document.addEventListener('click', function (e) {

        const btn = e.target.closest('.btn-delete');
        if (!btn) return;

        const id = btn.dataset.id;

        // ✅ ACTION DU FORM (DELETE avec ID)
        document.getElementById('deleteForm').action =
            "{{ route('telephone-mobiles.destroy', ':id') }}"
                .replace(':id', id);
    });

});
</script>

<script>
document.addEventListener("DOMContentLoaded", function () {

    const editForm = document.getElementById('editForm');

    editForm.addEventListener('submit', function (e) {
        e.preventDefault(); // ⛔ stop submit immédiat

        Swal.fire({
            title: 'Confirmer la modification',
            text: 'Voulez-vous enregistrer ces changements ?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#198754',
            cancelButtonColor: '#dc3545',
            confirmButtonText: 'Oui, modifier',
            cancelButtonText: 'Annuler'
        }).then((result) => {
            if (result.isConfirmed) {
                editForm.submit(); // ✅ submit réel
            }
        });
    });

});
</script>

<script>
document.addEventListener("DOMContentLoaded", function () {

    const deleteForm = document.getElementById('deleteForm');

    deleteForm.addEventListener('submit', function (e) {
        e.preventDefault();

        Swal.fire({
            title: 'Suppression',
            text: 'Cette action est irréversible. Continuer ?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Oui, supprimer',
            cancelButtonText: 'Annuler'
        }).then((result) => {
            if (result.isConfirmed) {
                deleteForm.submit();
            }
        });
    });

});
</script>