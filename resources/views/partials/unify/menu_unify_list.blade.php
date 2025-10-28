@if(Auth::user()->role_id == 1)
@include('partials.dashboard.admin.role.menu_role')
@endif

@if(Auth::user()->role_id == 1)
@include('partials.dashboard.admin.user.menu_user')
@endif

<li class="sidebar-item  has-sub active">
    <a href="#" class='sidebar-link'>
        <i class="fa-solid fa-rectangle-list"></i>
        <span>Unify</span>
    </a>
    <ul class="submenu active">
        <li class="submenu-item">
            
            <a href="{{ route('unify.index') }}"><i class="fa-solid fa-clipboard-list"></i>  Formulaire</a>
        </li>
        <li class="submenu-item active">
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

<li class="sidebar-item">
    <a href="{{ route('settings') }}" class='sidebar-link'>
        <i class="fa-solid fa-gear"></i>
        <span>Paramètres</span>
    </a>
</li>