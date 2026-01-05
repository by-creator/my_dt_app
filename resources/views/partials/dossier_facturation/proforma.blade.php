<div class="col-md-4 mb-3">
    <div class="card h-100 shadow-sm d-flex flex-column">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <span>Facture proforma</span>

            @php
                $proformaFiles = collect();

                foreach ($dossier->proformas as $proforma) {
                    if (isset($proforma->proforma['proforma'])) {
                        $proformaFiles = $proformaFiles->merge($proforma->proforma['proforma']);
                    }
                }
            @endphp

            <span class="badge bg-light text-dark">{{ $proformaFiles->count() }}</span>
        </div>

        <div class="card-body d-flex flex-column">
            <div class="mb-2">
                <br>
                <a href="#" class="btn btn-sm btn-info text-dark"
                   data-bs-toggle="modal"
                   data-bs-target="#generateModal{{ $dossier->id }}">
                    <i class="fa-solid fa-plus"></i>
                    Générer votre facture proforma
                </a>
            </div>

            @if ($proformaFiles->isNotEmpty())
                <div class="overflow-auto">
                    <ul class="list-group">
                        @foreach ($proformaFiles as $file)
                            @php
                                $url = $file['url'] ?? null;
                            @endphp

                            <li class="list-group-item d-flex flex-column">
                                <div class="mb-2">
                                    <span>{{ $file['original'] ?? 'Nom fichier inconnu' }}</span>
                                </div>

                                @if ($url)
                                    <div class="mb-2 d-grid gap-2 d-md-flex">
                                        <a href="{{ $url }}" target="_blank"
                                           class="btn btn-sm btn-primary ms-2">
                                            <i class="fa-solid fa-eye"></i>
                                            Ouvrir
                                        </a>

                                        <a href="#"
                                           class="btn btn-sm btn-success ms-2"
                                           data-bs-toggle="modal"
                                           data-type="proforma"
                                           data-bs-target="#validateProformaModal{{ $dossier->id }}">
                                            <i class="fa-solid fa-check-to-slot"></i>
                                            Valider
                                        </a>

                                        <a href="#"
                                           class="btn btn-sm btn-danger ms-2"
                                           data-bs-toggle="modal"
                                           data-type="proforma"
                                           data-bs-target="#deleteProformaModal{{ $dossier->id }}">
                                            <i class="fa-solid fa-trash"></i>
                                            Supprimer
                                        </a>
                                    </div>
                                @else
                                    <span class="text-muted">Fichier non disponible</span>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </div>
            @else
                <p class="text-muted mb-0">
                    Aucun fichier disponible pour facture proforma.
                </p>
            @endif
        </div>

        <div class="card-footer bg-white border-top-0">
            <form action="{{ route('dossier_facturation.proforma.relance', $dossier->id) }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-primary w-100">
                    <i class="fa-solid fa-bell"></i>
                    Effectuer une relance
                </button>
            </form>
        </div>
    </div>
</div>
