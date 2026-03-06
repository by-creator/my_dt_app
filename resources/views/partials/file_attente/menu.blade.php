<li class="sidebar-title">File d'attente</li>

<li class="sidebar-item {{ request()->routeIs('agents.*') ? 'active' : '' }}">
    <a href="{{ route('agents.index') }}" class="sidebar-link">
        <i class="fa-solid fa-user-tie"></i>
        <span>Agents</span>
    </a>
</li>

<li class="sidebar-item {{ request()->routeIs('services.*') ? 'active' : '' }}">
    <a href="{{ route('services.index') }}" class="sidebar-link">
        <i class="fa-solid fa-briefcase"></i>
        <span>Services</span>
    </a>
</li>

<li class="sidebar-item {{ request()->routeIs('gfa.tickets-detail*') ? 'active' : '' }}">
    <a href="{{ route('gfa.tickets-detail') }}" class="sidebar-link">
        <i class="fa-solid fa-ticket"></i>
        <span>Tickets</span>
    </a>
</li>

<li class="sidebar-item {{ request()->routeIs('public.screen') ? 'active' : '' }}">
    <a href="{{ route('public.screen') }}" class="sidebar-link" target="_blank">
        <i class="fa-solid fa-display"></i>
        <span>Écran d'affichage</span>
    </a>
</li>
