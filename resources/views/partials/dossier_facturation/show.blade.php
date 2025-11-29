<div class="container mt-4">
    <h4 class="mb-4"><u>Liste des documents</u></h4>

    <div class="row">
        @foreach(['proforma', 'facture', 'bon'] as $type)
        @php
        $files = $dossier->$type ?? [];
        $files = array_filter($files, fn($f) => !empty($f['path']));
        @endphp

        <div class="col-md-4 mb-3">
            <div class="card h-100 shadow-sm">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <span>{{ ucfirst($type) }}</span>
                    <span class="badge bg-light text-dark">{{ count($files) }}</span>
                    @if($type === 'proforma')
                    <a href="#" class="btn btn-sm btn-light text-dark">
                        <i class="fa-solid fa-upload"></i> Générer Proforma
                    </a>

                    @elseif($type === 'facture')
                    <a href="#" class="btn btn-sm btn-light text-dark">
                        <i class="fa-solid fa-upload"></i> Demander BAD
                    </a>
                    @endif
                </div>
                <div class="card-body">
                    @if(count($files) > 0)
                    <ul class="list-group list-group-flush">
                        @foreach($files as $file)
                        @php
                        $url = Storage::disk('b2')->url($file['path'] ?? '');
                        @endphp
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>{{ $file['original'] }}</span>
                            @if(!empty($file['path']))
                            <a href="{{ $url }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                <i class="fa-solid fa-eye"></i> Consulter
                            </a>
                            @if($type === 'proforma')
                            <a href="#" class="btn btn-sm btn-danger ms-2">
                                <i class="fa-solid fa-trash"> </i>
                            </a>
                            <a href="#" class="btn btn-sm btn-danger ms-2">
                                <i class="fa-solid fa-trash"> </i>
                            </a>
                            @endif
                            @else
                            <span class="text-muted">Pas de fichier</span>
                            @endif
                        </li>
                        @endforeach
                    </ul>
                    @else
                    <p class="text-muted mb-0">Aucun fichier disponible pour {{ $type }}.</p>
                    @endif
                </div>

            </div>
        </div>
        @endforeach
    </div>
</div>