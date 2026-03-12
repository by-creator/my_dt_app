@if(Auth::user()->role->name == "ADMIN" || Auth::user()->role->name == "SUPER_U" || Auth::user()->role->name == "FACTURATION" )
<li class="sidebar-item  has-sub ">
    <a href="#" class='sidebar-link'>
        <i class="fa-solid fa-folder"></i>
        <span>Validation </span>
    </a>
    <ul class="submenu">
        <li class="submenu-item">
            <a class='sidebar-link' href="{{ route('rattachement.index') }}"><i class="fa-solid fa-clipboard"></i> Gestion validations</a>
        </li>
        <li class="submenu-item ">
            <a class='sidebar-link' href="{{ route('rattachement.list') }}"><i class="fa-solid fa-clipboard"></i> Liste validations</a>
        </li>
    </ul>
</li>
<li class="sidebar-item  has-sub">
    <a href="#" class='sidebar-link'>
        <i class="fa-solid fa-folder"></i>
        <span>Unify</span>
    </a>
    <ul class="submenu">
        <li class="submenu-item">
            <a class='sidebar-link' href="{{ route('unify.index') }}"><i class="fa-solid fa-clipboard"></i> Formulaire Unify</a>
        </li>
        <li class="submenu-item ">
            <a class='sidebar-link' href="{{ route('ipaki.list') }}"><i class="fa-solid fa-list"></i> Liste tiers</a>
        </li>
        <li class="submenu-item ">
            <a class='sidebar-link' href="{{ route('unify.tutorial') }}"><i class="fa-solid fa-circle-info"></i> Tutoriel Unify</a>
        </li>
        <li class="submenu-item ">
            <a class='sidebar-link' href="{{ route('ipaki.admin') }}"><i class="fa-solid fa-toolbox"></i> Admin</a>
        </li>
    </ul>
</li>
<!--
<li class="sidebar-item  has-sub">
    <a href="#" class='sidebar-link'>
        <i class="fa-solid fa-folder"></i>
        <span>Proformas</span>
    </a>
    <ul class="submenu">
        <li class="submenu-item">
            <a class='sidebar-link' href="{{ route('dossier_facturation.proforma') }}"><i class="fa-solid fa-clipboard"></i> Gestion proformas</a>
        </li>
        <li class="submenu-item">
            <a class='sidebar-link' href="{{ route('dossier_facturation.proforma.list') }}"><i class="fa-solid fa-clipboard"></i> Liste proformas</a>
        </li>
    </ul>
</li>
<li class="sidebar-item  has-sub">
    <a href="#" class='sidebar-link'>
        <i class="fa-solid fa-folder"></i>
        <span>Factures</span>
    </a>
    <ul class="submenu">
        <li class="submenu-item ">
            <a class='sidebar-link' href="{{ route('dossier_facturation.facture') }}"><i class="fa-solid fa-clipboard"></i> Gestion factures</a>
        </li>
        <li class="submenu-item">
            <a class='sidebar-link' href="{{ route('dossier_facturation.facture.list') }}"><i class="fa-solid fa-clipboard"></i> Liste factures</a>
        </li>
    </ul>
</li>
<li class="sidebar-item  has-sub">
    <a href="#" class='sidebar-link'>
        <i class="fa-solid fa-folder"></i>
        <span>Bons à délivrer </span>
    </a>
    <ul class="submenu">
        <li class="submenu-item ">
            <a class='sidebar-link' href="{{ route('dossier_facturation.bon') }}"><i class="fa-solid fa-clipboard"></i> Gestion BAD</a>
        </li>
        <li class="submenu-item">
            <a class='sidebar-link' href="{{ route('dossier_facturation.bon.list') }}"><i class="fa-solid fa-clipboard"></i> Liste BAD</a>
        </li>
    </ul>
</li>
<li class="sidebar-item  has-sub">
    <a href="#" class='sidebar-link'>
        <i class="fa-solid fa-folder"></i>
        <span>Unify</span>
    </a>
    <ul class="submenu">
        <li class="submenu-item">
            <a class='sidebar-link' href="{{ route('unify.index') }}"><i class="fa-solid fa-clipboard"></i> Formulaire Unify</a>
        </li>
        <li class="submenu-item ">
            <a class='sidebar-link' href="{{ route('ipaki.list') }}"><i class="fa-solid fa-list"></i> Liste tiers</a>
        </li>
        <li class="submenu-item ">
            <a class='sidebar-link' href="{{ route('unify.tutorial') }}"><i class="fa-solid fa-circle-info"></i> Tutoriel Unify</a>
        </li>
        <li class="submenu-item ">
            <a class='sidebar-link' href="{{ route('ipaki.admin') }}"><i class="fa-solid fa-toolbox"></i> Admin</a>
        </li>
    </ul>
</li>
<li class="sidebar-item">
    <a class='sidebar-link' href="{{ route('dossier_facturation.tuto-video-index') }}"class='sidebar-link'>
        <i class="fa-solid fa-circle-info"></i>
        <span>Comment ça marche ?</span>
    </a>
</li>-->
@include('partials.ies.menu_ies')
@endif
<li class="sidebar-item">
    <a class='sidebar-link' href="{{ route('rattachement.index_remise') }}"class='sidebar-link'>
        <i class="fa-solid fa-percent"></i>
        <span>Gestion des remises</span>
    </a>
</li>
@if(Auth::user()->role->name == "ADMIN" || Auth::user()->role->name == "SUPER_U" )
<li class="sidebar-item">
    <a class='sidebar-link' href="{{ route('dossier_facturation.list_client') }}"class='sidebar-link'>
        <i class="fa-solid fa-user"></i>
        <span>Liste des clients</span>
    </a>
</li>
@endif






@if (session('error'))
<script>
    Swal.fire({
        icon: 'error',
        title: 'Erreur',
        text: "{{ session('error') }}",
    });
</script>
@endif
