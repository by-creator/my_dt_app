@if(Auth::user()->role->name == "ADMIN")
@include('partials.dashboard.admin.role.menu_role')
@endif