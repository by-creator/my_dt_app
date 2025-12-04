@include('partials.facturation.menu_facturation')

@if (session('error'))
<script>
Swal.fire({
    icon: 'error',
    title: 'Erreur',
    text: "{{ session('error') }}",
});
</script>
@endif
