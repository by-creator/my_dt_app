<li class="sidebar-item  has-sub ">
    <a href="#" class='sidebar-link'>
        <i class="fa-solid fa-circle-info"></i>
        <span>Validation </span>
    </a>
    <ul class="submenu">
        <li class="submenu-item">
            <a class='sidebar-link' href="{{ route('rattachement.index') }}"><i class="fa-solid fa-clipboard-list"></i> Gestion des validations</a>
        </li>
        <li class="submenu-item ">
            <a class='sidebar-link' href="{{ route('rattachement.list') }}"><i class="fa-solid fa-video"></i> Liste des validations</a>
        </li>
    </ul>
</li>
<li class="sidebar-item  has-sub">
    <a href="#" class='sidebar-link'>
        <i class="fa-solid fa-rectangle-list"></i>
        <span>Facturation</span>
    </a>
    <ul class="submenu">
        <li class="submenu-item">
            <a class='sidebar-link' href="{{ route('dossier_facturation.proforma') }}"><i class="fa-solid fa-clipboard-list"></i> Gestion des proformas</a>
        </li>
        <li class="submenu-item">
            <a class='sidebar-link' href="{{ route('dossier_facturation.proforma.list') }}"><i class="fa-solid fa-clipboard-list"></i> Liste des proformas</a>
        </li>
        <li class="submenu-item ">
            <a class='sidebar-link' href="{{ route('dossier_facturation.facture') }}"><i class="fa-solid fa-clipboard-list"></i> Gestion des factures</a>
        </li>
        <li class="submenu-item">
            <a class='sidebar-link' href="{{ route('dossier_facturation.facture.list') }}"><i class="fa-solid fa-clipboard-list"></i> Liste des factures</a>
        </li>
        <li class="submenu-item ">
            <a class='sidebar-link' href="{{ route('dossier_facturation.bon') }}"><i class="fa-solid fa-clipboard-list"></i> Gestion des BAD</a>
        </li>
        <li class="submenu-item">
            <a class='sidebar-link' href="{{ route('dossier_facturation.bon.list') }}"><i class="fa-solid fa-clipboard-list"></i> Liste des BAD</a>
        </li>
    </ul>
</li>
<li class="sidebar-item  has-sub ">
    <a href="#" class='sidebar-link'>
        <i class="fa-solid fa-circle-info"></i>
        <span>Comment ça marche </span>
    </a>
    <ul class="submenu">
        <li class="submenu-item">
            <a class='sidebar-link' href="{{ route('dossier_facturation.tuto-pdf-index') }}"><i class="fa-solid fa-clipboard-list"></i> Format PDF</a>
        </li>
        <li class="submenu-item ">
            <a class='sidebar-link' href="{{ route('dossier_facturation.tuto-video-index') }}"><i class="fa-solid fa-video"></i> Format vidéo</a>
        </li>
    </ul>
</li>
<li class="sidebar-item  has-sub">
    <a href="#" class='sidebar-link'>
        <i class="fa-solid fa-rectangle-list"></i>
        <span>Unify</span>
    </a>
    <ul class="submenu">
        <li class="submenu-item">
            <a class='sidebar-link' href="{{ route('unify.index') }}"><i class="fa-solid fa-clipboard-list"></i> Formulaire Unify</a>
        </li>
        <li class="submenu-item ">
            <a class='sidebar-link' href="{{ route('ipaki.list') }}"><i class="fa-solid fa-list"></i> Liste des tiers</a>
        </li>
        <li class="submenu-item ">
            <a class='sidebar-link' href="{{ route('unify.tutorial') }}"><i class="fa-solid fa-circle-info"></i> Tutoriel Unify</a>
        </li>
        <li class="submenu-item ">
            <a class='sidebar-link' href="{{ route('ipaki.admin') }}"><i class="fa-solid fa-toolbox"></i> Admin</a>
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