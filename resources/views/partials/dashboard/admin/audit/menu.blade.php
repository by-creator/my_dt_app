<li class="sidebar-item  has-sub active">
    <a href="#" class='sidebar-link'>
        <i class="fa-solid fa-rectangle-list"></i>
        <span>Administration</span>
    </a>
    <ul class="submenu">

        <li class="submenu-item">

            <a href="{{ route('role.index') }}"><i class="fa-solid fa-user-lock"></i> Gestion des rôles</a>
        </li>
        <li class="submenu-item">

            <a href="{{ route('user.index') }}"><i class="fa-solid fa-users"></i> Gestion des utilisateurs</a>
        </li>
        <li class="submenu-item">

            <a href="{{ route('admin.audit') }}"><i class="fa-solid fa-rectangle-list"></i> Suivi des logs</a>
    </ul>
</li>