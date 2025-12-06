<li class="sidebar-item  has-sub ">
    <a href="#" class='sidebar-link'>
        <i class="fa-solid fa-rectangle-list"></i>
        <span>Validation </span>
    </a>
    <ul class="submenu">
        <li class="submenu-item">
            <a class='sidebar-link' href="{{ route('rattachement.index') }}"><i class="fa-solid fa-clipboard-list"></i> Gestion validations</a>
        </li>
        <li class="submenu-item ">
            <a class='sidebar-link' href="{{ route('rattachement.list') }}"><i class="fa-solid fa-clipboard-list"></i> Liste validations</a>
        </li>
    </ul>
</li>

<li class="sidebar-item  has-sub">
    <a href="#" class='sidebar-link'>
        <i class="fa-solid fa-rectangle-list"></i>
        <span>Proformas</span>
    </a>
    <ul class="submenu">
        <li class="submenu-item">
            <a class='sidebar-link' href="{{ route('dossier_facturation.proforma') }}"><i class="fa-solid fa-clipboard-list"></i> Gestion proformas</a>
        </li>
        <li class="submenu-item">
            <a class='sidebar-link' href="{{ route('dossier_facturation.proforma.list') }}"><i class="fa-solid fa-clipboard-list"></i> Liste proformas</a>
        </li>
    </ul>
</li>
<li class="sidebar-item  has-sub">
    <a href="#" class='sidebar-link'>
        <i class="fa-solid fa-rectangle-list"></i>
        <span>Factures</span>
    </a>
    <ul class="submenu">
        <li class="submenu-item ">
            <a class='sidebar-link' href="{{ route('dossier_facturation.facture') }}"><i class="fa-solid fa-clipboard-list"></i> Gestion factures</a>
        </li>
        <li class="submenu-item">
            <a class='sidebar-link' href="{{ route('dossier_facturation.facture.list') }}"><i class="fa-solid fa-clipboard-list"></i> Liste factures</a>
        </li>
    </ul>
</li>
<li class="sidebar-item  has-sub">
    <a href="#" class='sidebar-link'>
        <i class="fa-solid fa-rectangle-list"></i>
        <span>Bons à délivrer </span>
    </a>
    <ul class="submenu">
        <li class="submenu-item ">
            <a class='sidebar-link' href="{{ route('dossier_facturation.bon') }}"><i class="fa-solid fa-clipboard-list"></i> Gestion BAD</a>
        </li>
        <li class="submenu-item">
            <a class='sidebar-link' href="{{ route('dossier_facturation.bon.list') }}"><i class="fa-solid fa-clipboard-list"></i> Liste BAD</a>
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

@if (session('error'))
<script>
    Swal.fire({
        icon: 'error',
        title: 'Erreur',
        text: "{{ session('error') }}",
    });
</script>
@endif