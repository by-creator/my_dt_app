
<li class="sidebar-item">
    <a class='sidebar-link' href="{{ route('dossier_facturation.validation-index') }}" class='sidebar-link'>
        ✅
        <span>Validation</span>
    </a>
</li>
<li class="sidebar-item">
    <a class='sidebar-link' href="{{ route('dossier_facturation.paiement-index') }}" class='sidebar-link'>
        💵
        <span>Paiement</span>
    </a>
</li>
<li class="sidebar-item">
    <a class='sidebar-link' href="#" class='sidebar-link' id="reductionLink">
        📋
        <span>Demande de réduction</span>
    </a>
</li>
<li class="sidebar-item">
    <a class='sidebar-link' href="{{ route('dossier_facturation.tuto-video-index') }}"class='sidebar-link'>
        ❓
        <span>Comment ça marche ?</span>
    </a>
</li>

<script>
document.getElementById('reductionLink').addEventListener('click', function (e) {
    e.preventDefault(); // empêche le lien de changer de page

    Swal.fire({
        icon: 'info',
        title: 'Information',
        text: 'Ce menu n\'est pas encore disponible.',
        confirmButtonText: 'OK'
    });
});
</script>
