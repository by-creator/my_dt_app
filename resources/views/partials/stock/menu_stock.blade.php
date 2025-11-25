@if(Auth::user()->role->name == "ADMIN")
@include('partials.dashboard.admin.role.menu_role')
@elseif(Auth::user()->role->name == "SUPER_U")
@include('partials.dashboard.admin.super_u.menu')
@endif