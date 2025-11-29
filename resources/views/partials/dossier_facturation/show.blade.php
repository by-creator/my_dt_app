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
                    @if($type === 'proforma')
                    <a href="#" class="btn btn-sm btn-light text-dark">
                        <i class="fa-solid fa-file"></i> Générer Proforma
                    </a>
                    @endif
                    <span class="badge bg-light text-dark">{{ count($files) }}</span>
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
                            <a href="{{ $url }}" target="_blank" class="btn btn-sm btn-primary">
                                <i class="fa-solid fa-eye"></i>
                            </a>
                            @if($type === 'proforma')
                            <a href="#" class="btn btn-sm btn-success ms-2">
                                <i class="fa-solid fa-check-to-slot"></i>
                            </a>
                            <a href="#" class="btn btn-sm btn-danger ms-2">
                                <i class="fa-solid fa-trash"> </i>
                            </a>
                            @elseif($type === 'facture')
                            <a href="#" class="btn btn-sm btn-primary ms-2">
                                <i class="fa-solid fa-plus"> </i>
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

                <div class="card-body">
                    <p class="card-text"></p>
                    @if($type === 'proforma')
                    <a href="#" class="btn btn-primary w-100">
                        <i class="fa-solid fa-bell"></i> Effectuer une relance
                    </a>
                    @elseif($type === 'facture')
                    <a href="#" class="btn btn-primary w-100">
                        <i class="fa-solid fa-bell"></i> Effectuer une relance
                    </a>
                    @elseif($type === 'bon')
                    <a href="#" class="btn btn-primary w-100">
                        <i class="fa-solid fa-bell"></i> Effectuer une relance
                    </a>
                    @endif
                </div>

            </div>
        </div>
        @endforeach
    </div>
</div>