<div class="col-md-4 mb-3">
    <div class="card h-100 shadow-sm d-flex flex-column">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <span>Facture définitive</span>

            @php
            // On compte tous les fichiers facture de ce dossier
            $factureFiles = collect();
            foreach ($dossier->factures as $facture) {
            $factureFiles = $factureFiles->merge($facture->facture ?? []);
            }
            @endphp
            <span class="badge bg-light text-dark">{{ $factureFiles->count() }}</span>
        </div>

        <div class="card-body flex-grow-1 d-flex flex-column">
            @if($factureFiles->isNotEmpty())
            <div class="flex-grow-1 overflow-auto">
                <ul class="list-group">
                    @foreach($factureFiles as $file)
                    @php
                    $url = Storage::disk('b2')->url($file['path'] ?? '');
                    @endphp
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span>{{ $file['original'] }}</span>
                        @if(!empty($file['path']))
                        <a href="{{ $url }}" target="_blank" class="btn btn-sm btn-primary">
                            <i class="fa-solid fa-eye"></i>
                            Voir
                        </a>
                        <a href="#"
                            class="btn btn-sm btn-success ms-2"
                            data-bs-toggle="modal"
                            data-type="facture"
                            data-bs-target="#validateFactureModal{{ $dossier->id }}">
                            <i class="fa-solid fa-check-to-slot"></i>
                            Valider
                        </a>
                        <a href="#"
                            class="btn btn-sm btn-danger ms-2"
                            data-bs-toggle="modal"
                            data-type="facture"
                            data-bs-target="#complementFactureModal{{ $dossier->id }}">
                            <i class="fa-solid fa-plus"></i>
                            Ajouter
                        </a>
                        @else
                        <span class="text-muted">Pas de fichier</span>
                        @endif
                    </li>
                    @endforeach
                </ul>
            </div>
            @else
            <p class="text-muted mb-0">Aucun fichier disponible pour facture.</p>
            @endif
        </div>

        <div class="card-footer bg-white border-top-0">
            <a href="#" class="btn btn-primary w-100">
                <i class="fa-solid fa-bell"></i> Effectuer une relance
            </a>
        </div>
    </div>
</div>