<li class="sidebar-item active">
    <a href="{{ route('rattachement.index') }}" class='sidebar-link'>
        <i class="fa-solid fa-check-to-slot"></i>
        <span>Validation</span>
    </a>
</li>
<li class="sidebar-item">
    <a href="{{ route('dossier_facturation.proforma') }}" class='sidebar-link'>
        <i class="fa-solid fa-clipboard-list"></i>
        <span>Facturation</span>
    </a>
</li>
<li class="sidebar-item  has-sub">
    <a href="#" class='sidebar-link'>
        <i class="fa-solid fa-rectangle-list"></i>
        <span>Unify</span>
    </a>
    <ul class="submenu">
        <li class="submenu-item">
            <a href="{{ route('unify.index') }}"><i class="fa-solid fa-clipboard-list"></i> Formulaire Unify</a>
        </li>
        <li class="submenu-item ">
            <a href="{{ route('ipaki.list') }}"><i class="fa-solid fa-list"></i> Liste des tiers</a>
        </li>
        <li class="submenu-item ">
            <a href="{{ route('unify.tutorial') }}"><i class="fa-solid fa-circle-info"></i> Tutoriel Unify</a>
        </li>
        <li class="submenu-item ">
            <a href="{{ route('ipaki.admin') }}"><i class="fa-solid fa-toolbox"></i> Admin</a>
        </li>
    </ul>
</li>


@if (session('error'))
<script>
    Swal.fire({
        icon: 'error',
        title: 'Erreur',
        text: "{{ session('error') }}",
    });
</script>
@endif