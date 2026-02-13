<li class="sidebar-item  has-sub ">
    <a href="#" class='sidebar-link'>
        📁
        <span>Validation </span>
    </a>
    <ul class="submenu">
        <li class="submenu-item">
            <a class='sidebar-link' href="{{ route('rattachement.index') }}">📋 Gestion validations</a>
        </li>
        <li class="submenu-item ">
            <a class='sidebar-link' href="{{ route('rattachement.list') }}">📋 Liste validations</a>
        </li>
    </ul>
</li>

<li class="sidebar-item  has-sub">
    <a href="#" class='sidebar-link'>
        📁
        <span>Proformas</span>
    </a>
    <ul class="submenu">
        <li class="submenu-item">
            <a class='sidebar-link' href="{{ route('dossier_facturation.proforma') }}">📋 Gestion proformas</a>
        </li>
        <li class="submenu-item">
            <a class='sidebar-link' href="{{ route('dossier_facturation.proforma.list') }}">📋 Liste proformas</a>
        </li>
    </ul>
</li>
<li class="sidebar-item  has-sub">
    <a href="#" class='sidebar-link'>
        📁
        <span>Factures</span>
    </a>
    <ul class="submenu">
        <li class="submenu-item ">
            <a class='sidebar-link' href="{{ route('dossier_facturation.facture') }}">📋 Gestion factures</a>
        </li>
        <li class="submenu-item">
            <a class='sidebar-link' href="{{ route('dossier_facturation.facture.list') }}">📋 Liste factures</a>
        </li>
    </ul>
</li>
<li class="sidebar-item  has-sub">
    <a href="#" class='sidebar-link'>
        📁
        <span>Bons à délivrer </span>
    </a>
    <ul class="submenu">
        <li class="submenu-item ">
            <a class='sidebar-link' href="{{ route('dossier_facturation.bon') }}">📋 Gestion BAD</a>
        </li>
        <li class="submenu-item">
            <a class='sidebar-link' href="{{ route('dossier_facturation.bon.list') }}">📋 Liste BAD</a>
        </li>
    </ul>
</li>
<li class="sidebar-item  has-sub">
    <a href="#" class='sidebar-link'>
        📁
        <span>Remises </span>
    </a>
    <ul class="submenu">
        <li class="submenu-item ">
            <a class='sidebar-link' href="#">📋 Gestion remises</a>
        </li>
        <li class="submenu-item">
            <a class='sidebar-link' href="#">📋 Liste remises</a>
        </li>
    </ul>
</li>
<li class="sidebar-item  has-sub">
    <a href="#" class='sidebar-link'>
        📁
        <span>Unify</span>
    </a>
    <ul class="submenu">
        <li class="submenu-item">
            <a class='sidebar-link' href="{{ route('unify.index') }}">📋 Formulaire Unify</a>
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
@if(Auth::user()->role->name == "ADMIN" || Auth::user()->role->name == "SUPER_U" )
<li class="sidebar-item">
    <a class='sidebar-link' href="{{ route('dossier_facturation.list_client') }}"class='sidebar-link'>
        👥
        <span>Liste des clients</span>
    </a>
</li>
@include('partials.ies.menu_ies')
@endif

<li class="sidebar-item">
    <a class='sidebar-link' href="{{ route('dossier_facturation.tuto-video-index') }}"class='sidebar-link'>
        ❓
        <span>Comment ça marche ?</span>
    </a>
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