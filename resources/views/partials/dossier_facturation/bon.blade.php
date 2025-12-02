<div class="col-md-4 mb-3">
    <div class="card h-100 shadow-sm d-flex flex-column">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <span>Bon à délivrer</span>

            @php
            // On compte tous les fichiers bon de ce dossier
            $bonFiles = collect();
            foreach ($dossier->bons as $bon) {
            $bonFiles = $bonFiles->merge($bon->bon ?? []);
            }
            @endphp
            <span class="badge bg-light text-dark">{{ $bonFiles->count() }}</span>
        </div>

        <div class="card-body flex-grow-1 d-flex flex-column">
            @if($bonFiles->isNotEmpty())
            <div class="flex-grow-1 overflow-auto">
                <ul class="list-group">
                    @foreach($bonFiles as $file)
                    @php
                    $url = Storage::disk('b2')->url($file['path'] ?? '');
                    @endphp
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span>{{ $file['original'] }}</span>
                        @if(!empty($file['path']))
                        <a href="{{ $url }}" target="_blank" class="btn btn-sm btn-primary">
                            <i class="fa-solid fa-eye"></i>
                        </a>
                        @else
                        <span class="text-muted">Pas de fichier</span>
                        @endif
                    </li>
                    @endforeach
                </ul>
            </div>
            @else
            <p class="text-muted mb-0">Aucun fichier disponible pour bon.</p>
            @endif
        </div>

        <div class="card-footer bg-white border-top-0">
            <a href="#" class="btn btn-primary w-100">
                <i class="fa-solid fa-bell"></i> Effectuer une relance
            </a>
        </div>
    </div>
</div>