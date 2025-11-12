@if(Auth::user()->role->name == "ADMIN")
<li class="sidebar-item ">
    <a href="{{ route('role.index') }}" class='sidebar-link'>
        <i class="fa-solid fa-user-lock"></i>
        <span>Gestion des rôles</span>
    </a>
</li>

<li class="sidebar-item">
    <a href="{{ route('user.index') }}" class='sidebar-link'>
        <i class="fa-solid fa-users"></i>
        <span>Gestion des utilisateurs</span>
    </a>
</li>
<li class="sidebar-item  has-sub">
    <a href="#" class='sidebar-link'>
        <i class="fa-solid fa-rectangle-list"></i>
        <span>Informatique</span>
    </a>
    <ul class="submenu">
        <li class="submenu-item">

            <a href="{{ route('user_accounts.index') }}"><i class="fa-solid fa-clipboard-list"></i> Gestion des comptes</a>
        </li>
    </ul>
</li>
<li class="sidebar-item  has-sub active">
    <a href="#" class='sidebar-link'>
        <i class="fa-solid fa-rectangle-list"></i>
        <span>Facturation</span>
    </a>
    <ul class="submenu">
        <li class="submenu-item">
            <a href="{{ route('rattachement.index') }}"><i class="fa-solid fa-file-import"></i> Rattachement BL</a>
        </li>
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
<li class="sidebar-item  has-sub">
    <a href="#" class='sidebar-link'>
        <i class="fa-solid fa-rectangle-list"></i>
        <span>Ipaki Extranet</span>
    </a>
    <ul class="submenu">
        <li class="submenu-item">

            <a href="{{ route('ies.validation') }}"><i class="fa-solid fa-check-to-slot"></i> Validation</a>
        </li>
        <li class="submenu-item">

            <a href="{{ route('ies.create') }}"><i class="fa-solid fa-user-plus"></i> Création</a>
        </li>
        <li class="submenu-item ">
            <a href="{{ route('ies.reset-password') }}"><i class="fa-solid fa-pen-to-square"></i> Réinitialisation</a>
        </li>
         <li class="submenu-item">

            <a href="{{ route('ies.link') }}"><i class="fa-solid fa-envelope"></i> Lien</a>
        </li>
    </ul>
</li>
<li class="sidebar-item  has-sub">
    <a href="#" class='sidebar-link'>
        <i class="fa-solid fa-rectangle-list"></i>
        <span>Stock</span>
    </a>
    <ul class="submenu">
        <li class="submenu-item">

            <a href="{{ route('ordinateur.index') }}"><i class="fa-solid fa-computer"></i> Ordinateur</a>
        </li>
        <li class="submenu-item">

            <a href="{{ route('clavier.index') }}"><i class="fa-solid fa-computer"></i> Clavier</a>
        </li>
        <li class="submenu-item">

            <a href="{{ route('souris.index') }}"><i class="fa-solid fa-computer"></i> Souris</a>
        </li>
        <li class="submenu-item">

            <a href="{{ route('ecran.index') }}"><i class="fa-solid fa-computer"></i> Ecran</a>
        </li>
        <li class="submenu-item">

            <a href="{{ route('station.index') }}"><i class="fa-solid fa-computer"></i> Station</a>
        </li>
        <li class="submenu-item ">
            <a href="{{ route('telephone-fixe.index') }}"><i class="fa-solid fa-phone"></i> Postes fixes</a>
        </li>
    </ul>
</li>
@elseif(Auth::user()->role->name == "FACTURATION" || Auth::user()->role->name == "SUPER_U")
<li class="sidebar-item  has-sub active">
    <a href="#" class='sidebar-link'>
        <i class="fa-solid fa-rectangle-list"></i>
        <span>Facturation</span>
    </a>
    <ul class="submenu">
        <li class="submenu-item">
            <a href="{{ route('rattachement.index') }}"><i class="fa-solid fa-file-import"></i> Rattachement BL</a>
        </li>
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


