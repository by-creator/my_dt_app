<nav class="gfa-navbar">
    <div>
        <span class="brand">Gestion File d'attente</span>
    </div>

    <div class="gfa-navbar-links">
        <a href="{{ route('gfa.tickets-detail') }}"
           class="{{ request()->routeIs('gfa.tickets-detail') ? 'active' : '' }}">
            🎫 Tickets
        </a>

        <a href="{{ route('services.index') }}"
           class="{{ request()->routeIs('services.*') ? 'active' : '' }}">
            🛎️ Services
        </a>

        <a href="{{ route('agents.index') }}"
           class="{{ request()->routeIs('agents.*') ? 'active' : '' }}">
            👨‍💼 Agents
        </a>
    </div>
</nav>
