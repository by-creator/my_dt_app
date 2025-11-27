@if(Auth::user()->role->name == "ADMIN")
<li class="sidebar-item  has-sub active">
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
@elseif(Auth::user()->role->name == "SUPER_U")
@include('partials.dashboard.admin.super_u.menu')
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


