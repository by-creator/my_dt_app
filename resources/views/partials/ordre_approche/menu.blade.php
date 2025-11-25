@if(Auth::user()->role->name == "ADMIN")
@include('partials.dashboard.admin.role.menu_role')
@elseif(Auth::user()->role->name == "SUPER_U")
@include('partials.dashboard.admin.super_u.menu')
@elseif(Auth::user()->role->name == "OPERATIONS" || Auth::user()->role->name == "QHSE")
<li class="sidebar-item  has-sub">
    <a href="#" class='sidebar-link'>
        <i class="fa-solid fa-rectangle-list"></i>
        <span>Ordre d'approche</span>
    </a>
    <ul class="submenu">
        <li class="submenu-item">

            <a href="{{ route('ordre_approche.vehicule') }}"><i class="fa-solid fa-car"></i> Véhicule</a>
        </li>
        <li class="submenu-item">

            <a href="{{ route('ordre_approche.conteneur') }}"><i class="fa-solid fa-box"></i> Conteneur</a>
        </li>
        <li class="submenu-item">

            <a href="{{ route('ordre_approche.gk') }}"><i class="fa-solid fa-boxes-stacked"></i> GK</a>
        </li>
    </ul>
</li>
@endif