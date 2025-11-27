
@if(Auth::user()->role->name == "SUPER_U")
@include('partials.dashboard.admin.super_u.menu')
@elseif(Auth::user()->role->name == "OPERATIONS" || Auth::user()->role->name == "QHSE")

<li class="sidebar-item ">
    <a href="{{ route('ordre_approche.index') }}" class='sidebar-link'>
        <i class="fa-solid fa-clipboard-list"></i>
        <span>Ordre approche</span>
    </a>
</li>
@endif