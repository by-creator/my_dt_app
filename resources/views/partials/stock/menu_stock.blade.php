@if(Auth::user()->role->name == "ADMIN")
<li class="sidebar-item  has-sub active">
    <a href="#" class='sidebar-link'>
        <i class="fa-solid fa-rectangle-list"></i>
        <span>Stock</span>
    </a>
    <ul class="submenu">
        <li class="submenu-item">

            <a href="{{ route('ordinateur.index') }}"><i class="fa-solid fa-computer"></i> Ordinateur</a>
        </li>
        <li class="submenu-item">

            <a href="{{ route('clavier.index') }}"><i class="fa-solid fa-keyboard"></i> Clavier</a>
        </li>
        <li class="submenu-item">

            <a href="{{ route('souris.index') }}"><i class="fa-solid fa-computer-mouse"></i> Souris</a>
        </li>
        <li class="submenu-item">

            <a href="{{ route('ecran.index') }}"><i class="fa-solid fa-desktop"></i> Ecran</a>
        </li>
        <li class="submenu-item">

            <a href="{{ route('station.index') }}"><i class="fa-solid fa-shuffle"></i> Station</a>
        </li>
        <li class="submenu-item ">
            <a href="{{ route('telephone-fixe.index') }}"><i class="fa-solid fa-phone"></i> Postes fixes</a>
        </li>
    </ul>
</li>
@elseif(Auth::user()->role->name == "SUPER_U")
@include('partials.dashboard.admin.super_u.menu')
@endif