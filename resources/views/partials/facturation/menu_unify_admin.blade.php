@if(Auth::user()->role->name == "ADMIN")
@include('partials.facturation.menu_facturation')
@elseif(Auth::user()->role->name == "SUPER_U")
@include('partials.dashboard.admin.super_u.menu')
@elseif(Auth::user()->role->name == "FACTURATION")
@include('partials.facturation.menu_facturation')

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


