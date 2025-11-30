<div class="col-md-4 mb-4">

@php
    $proformaFiles = collect();
    foreach ($dossier->proformas as $proforma) {
        $proformaFiles = $proformaFiles->merge($proforma->proforma ?? []);
    }
@endphp

<div class="card doc-card p-4 h-100 d-flex flex-column">

    <!-- HEADER ULTRA MODERNE -->
    <div class="doc-header d-flex justify-content-between align-items-center mb-4">
        <div class="d-flex align-items-center gap-2">
            <div class="folder-icon" style="width:45px;height:45px;">
                <i class="fa-solid fa-file-invoice"></i>
            </div>
            <span class="doc-title">Proforma</span>
        </div>

        <div class="d-flex align-items-center gap-2">
            <span class="doc-count">{{ $proformaFiles->count() }}</span>

            <a href="#"
               class="btn generate-btn btn-sm"
               data-bs-toggle="modal"
               data-bs-target="#generateModal{{ $dossier->id }}">
               <i class="fa-solid fa-plus"></i>
            </a>
        </div>
    </div>

    <!-- BODY -->
    <div class="flex-grow-1">
        @if($proformaFiles->isNotEmpty())

            @foreach($proformaFiles as $file)
                @php
                    $url = Storage::disk('b2')->url($file['path'] ?? '');
                @endphp

                <div class="file-item d-flex justify-content-between align-items-center">

                    <span title="{{ $file['original'] }}">
                        <i class="fa-solid fa-file-pdf text-danger me-1"></i>
                        {{ $file['original'] }}
                    </span>

                    @if(!empty($file['path']))
                        <div class="d-flex">
                            <a href="{{ $url }}" target="_blank" class="btn btn-primary file-btn">
                                <i class="fa-solid fa-eye"></i>
                            </a>

                            <a href="#" class="btn btn-success file-btn ms-2">
                                <i class="fa-solid fa-check"></i>
                            </a>

                            <a href="#" class="btn btn-danger file-btn ms-2">
                                <i class="fa-solid fa-trash"></i>
                            </a>
                        </div>
                    @else
                        <span class="text-muted small">Aucun fichier</span>
                    @endif

                </div>
            @endforeach

        @else
            <div class="text-center text-muted mt-4">
                <i class="fa-regular fa-folder-open fa-2x mb-2"></i>
                <p>Aucun fichier disponible</p>
            </div>
        @endif
    </div>

    <!-- FOOTER -->
    <div class="mt-4 text-center">
        <a href="#" class="btn relance-btn w-100">
            <i class="fa-solid fa-bell me-1"></i>
            Effectuer une relance
        </a>
    </div>

</div>
</div>
