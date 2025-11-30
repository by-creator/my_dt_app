<div class="col-md-4 mb-3">
    <div class="card h-100 shadow-sm">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <span>Proforma</span>
            <a href="#"
               class="btn btn-sm btn-light text-dark"
               data-bs-toggle="modal"
               data-bs-target="#generateModal{{ $dossier->id }}">
               <i class="fa-solid fa-plus"></i> Générer
            </a>
            @php
                // On compte tous les fichiers proforma de ce dossier
                $proformaFiles = collect();
                foreach ($dossier->proformas as $proforma) {
                    $proformaFiles = $proformaFiles->merge($proforma->proforma ?? []);
                }
            @endphp
            <span class="badge bg-light text-dark">{{ $proformaFiles->count() }}</span>
        </div>

        <div class="card-body">
            @if($proformaFiles->isNotEmpty())
                <ul class="list-group list-group-flush">
                    @foreach($proformaFiles as $file)
                        @php
                            $url = Storage::disk('b2')->url($file['path'] ?? '');
                        @endphp
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>{{ $file['original'] }}</span>
                            @if(!empty($file['path']))
                                <a href="{{ $url }}" target="_blank" class="btn btn-sm btn-primary">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                                <a href="#" class="btn btn-sm btn-success ms-2">
                                    <i class="fa-solid fa-check-to-slot"></i>
                                </a>
                                <a href="#" class="btn btn-sm btn-danger ms-2">
                                    <i class="fa-solid fa-trash"></i>
                                </a>
                            @else
                                <span class="text-muted">Pas de fichier</span>
                            @endif
                        </li>
                    @endforeach
                </ul>
            @else
                <p class="text-muted mb-0">Aucun fichier disponible pour Proforma.</p>
            @endif
        </div>

        <div class="card-body">
            <a href="#" class="btn btn-primary w-100">
                <i class="fa-solid fa-bell"></i> Effectuer une relance
            </a>
        </div>
    </div>
</div>





@if (session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Demande de pro-forma',
        text: "{{ session('success') }}",
        showConfirmButton: true
    });
</script>
@endif