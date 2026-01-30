<form method="post" action="{{route('unify.add')}}" class="form" enctype="multipart/form-data">
    @csrf

    @if (session('create'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Ajout',
            text: "{{ session('create') }}",
            showConfirmButton: true
        });
    </script>
    @endif

    @if(Auth::user()->role->name == "ADMIN" || Auth::user()->role->name == "FACTURATION" || Auth::user()->role->name == "SUPER_U")
    @include('partials.facturation.unify_infos')
    @include('partials.facturation.personal_infos')
    @include('partials.facturation.society_infos')
    @else
    @endif
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="col-12 d-flex justify-content-center">
                    <button type="submit" name="submit" value="fiche" class="btn btn-sm btn-outline-primary me-1 mb-1">📋 Imprimer Fiche </button>
                    <button type="submit" name="submit" value="attestation" class="btn btn-sm btn-outline-primary me-1 mb-1">📋 Imprimer Attestation </button>
                    <button type="submit" name="submit" value="sendTiers" class="btn btn-sm btn-outline-primary me-1 mb-1">📋 Envoyer le tiers</button>
                </div>
            </div>
        </div>
    </div>
</form>