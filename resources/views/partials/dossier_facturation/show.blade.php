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

<!-- Modal Génération -->
<div class="modal fade" id="generateModal{{ $dossier->id }}" tabindex="-1" aria-labelledby="generateModalLabel{{ $dossier->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('dossier_facturation.proforma.generate', $dossier->id) }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="generateModalLabel{{ $dossier->id }}">Générer Proforma</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <label for="documentDate{{ $dossier->id }}" class="form-label">Date du document</label>
                    <input type="date"
                           name="documentDate"
                           id="documentDate{{ $dossier->id }}"
                           class="form-control"
                           required>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa-solid fa-check-to-slot"></i> Générer
                    </button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                        <i class="fa-solid fa-square-xmark"></i> Annuler
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


@if (session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Demande de proforma',
        text: "{{ session('success') }}",
        showConfirmButton: true
    });
</script>
@elseif (session('info'))
<script>
    Swal.fire({
        icon: 'info',
        title: 'Demande de proforma',
        text: "{{ session('info') }}",
        showConfirmButton: true
    });
</script>
@endif