@push('scripts')
@if (session('success'))
<script>
Toast.fire({
    icon: 'success',
    title: @json(session('success'))
});
</script>
@endif

@if ($errors->any())
<script>
Toast.fire({
    icon: 'error',
    title: 'Une erreur est survenue, veuillez vérifier le formulaire'
});
</script>
@endif

@if (session('info'))
<script>
Toast.fire({
    icon: 'info',
    title: @json(session('info'))
});
</script>
@endif
@endpush