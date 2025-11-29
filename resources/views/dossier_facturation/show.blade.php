@extends('partials.app')

@section('content')
<div class="container">
    <h1>Dossier Facturation #{{ $dossier->id }}</h1>

    @foreach (['proforma', 'facture', 'bon'] as $type)
        <div class="mb-4">
            <h3>{{ ucfirst($type) }}</h3>

            @php
                // récupère le tableau de fichiers pour ce type
                $files = $dossier->$type ?? [];
                // filtre les fichiers sans path
                $files = array_filter($files, fn($f) => !empty($f['path']));
            @endphp

            @if (!empty($files))
                <ul>
                    @foreach ($files as $file)
                        @php
                            $url = Storage::disk('b2')->url($file['path']);
                        @endphp
                        <li class="mb-1">
                            📄 {{ $file['original'] ?? 'Fichier inconnu' }}
                            <a href="{{ $url }}" target="_blank" class="btn btn-sm btn-primary">
                                Ouvrir
                            </a>
                        </li>
                    @endforeach
                </ul>
            @else
                <p class="text-muted">Aucun fichier disponible pour {{ $type }}.</p>
            @endif
        </div>
    @endforeach
</div>
@endsection
