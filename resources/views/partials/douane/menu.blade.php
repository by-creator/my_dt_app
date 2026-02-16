<li class="sidebar-item {{ request()->routeIs('douane.*') ? 'active' : '' }}">
    <a href="{{route('douane.index')}}" class='sidebar-link'>
        <i class="fa-solid fa-folder"></i>
        <span>Gestion douanière</span>
    </a>
</li>