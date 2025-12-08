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

        <div class="card-body  d-flex flex-column">
            <div class="mb-2">
                <br>
                <br>
            </div>
            @if($bonFiles->isNotEmpty())
            <div class="overflow-auto">
                <ul class="list-group">
                    @foreach($bonFiles as $file)
                    @php
                    $url = Storage::disk('b2')->url($file['path'] ?? '');
                    @endphp
                    <li class="list-group-item d-flex flex-column">
                        <div class="mb-2">
                            <span>{{ $file['original'] }}</span>
                        </div>
                        @if(!empty($file['path']))
                        <div class="mb-2 d-grid gap-2 d-md-flex">
                            <a href="{{ $url }}" target="_blank" class="btn btn-sm btn-primary">
                                <i class="fa-solid fa-eye"></i>
                                Ouvrir
                            </a>
                        </div>
                        @else
                        <span class="text-muted">Pas de fichier</span>
                        @endif
                    </li>
                    @endforeach
                </ul>
            </div>
            @else
            <p class="text-muted mb-0">Aucun fichier disponible pour bon à délivrer.</p>
            @endif
        </div>

        <div class="card-footer bg-white border-top-0">
            <form action="{{ route('dossier_facturation.bon.relance', $dossier->id) }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-primary w-100">
                    <i class="fa-solid fa-bell"></i> Effectuer une relance
                </button>
            </form>
        </div>
    </div>
</div>

@if (session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Information',
        text: "{{ session('success') }}",
        showConfirmButton: true
    });
</script>
@elseif (session('info'))
<script>
    Swal.fire({
        icon: 'info',
        title: 'Information',
        text: "{{ session('info') }}",
        showConfirmButton: true
    });
</script>
@endif