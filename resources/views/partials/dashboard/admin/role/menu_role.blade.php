<li class="sidebar-item active ">
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
        <span>Unify</span>
    </a>
    <ul class="submenu">
        <li class="submenu-item">
            
            <a href="{{ route('unify.index') }}"><i class="fa-solid fa-clipboard-list"></i>  Formulaire</a>
        </li>
        <li class="submenu-item ">
            <a href="{{ route('ipaki.list') }}"><i class="fa-solid fa-list"></i>  Liste</a>
        </li>
        <li class="submenu-item ">
            <a href="{{ route('unify.tutorial') }}"><i class="fa-solid fa-circle-info"></i>  Tutoriel</a>
        </li>
        <li class="submenu-item ">
            <a href="{{ route('ipaki.admin') }}"><i class="fa-solid fa-toolbox"></i>  Admin</a>
        </li>
    </ul>
</li>

