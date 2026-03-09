<li class="sidebar-item  has-sub active">
    <a href="#" class='sidebar-link'>
        <i class="fa-solid fa-rectangle-list"></i>
        <span>Informatique</span>
    </a>
    <ul class="submenu">
        <li class="submenu-item">
            <a href="{{ route('user_accounts.index') }}"><i class="fa-solid fa-clipboard-list"></i> Gestion des comptes</a>
        </li>
        <li class="submenu-item">
            <a href="{{ route('machines.index') }}"><i class="fa-solid fa-desktop"></i> Machine</a>
        </li>
        <li class="submenu-item">
            <a href="{{ route('poste_fixes.index') }}"><i class="fa-solid fa-phone"></i> Poste Fixe</a>
        </li>
    </ul>
</li>



@if (session('error'))
<script>
Swal.fire({
    icon: 'error',
    title: 'Erreur',
    text: "{{ session('error') }}",
});
</script>
@endif


