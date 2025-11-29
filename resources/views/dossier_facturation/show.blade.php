@extends('partials.app')

@section('content')

@foreach (['proforma', 'facture', 'bon'] as $type)
    <div class="mb-4">
        <h5 class="mb-2">{{ ucfirst($type) }}</h5>

        @php
            $files = $dossier->$type ?? [];
            $files = array_filter($files, fn($f) => !empty($f['path']));
        @endphp

        @if (!empty($files))
            <table class="table table-bordered table-striped table-hover">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Nom du fichier</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($files as $index => $file)
                        @php
                            $url = Storage::disk('b2')->url($file['path']);
                        @endphp
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>
                                <span class="badge bg-info text-dark">{{ $file['original'] }}</span>
                            </td>
                            <td>
                                <a href="{{ $url }}" target="_blank" class="btn btn-sm btn-primary">
                                    Ouvrir
                                </a>

                                {{-- Bouton supplémentaire uniquement pour proforma --}}
                                @if($type === 'proforma')
                                    <a href="#" 
                                       class="btn btn-sm btn-success">
                                        Valider
                                    </a>
                                @elseif($type === 'facture')
                                    <a href="#" 
                                       class="btn btn-sm btn-success">
                                        Demander BAD
                                    </a>
                                    @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="text-muted">Aucun fichier disponible pour {{ $type }}.</p>
        @endif
    </div>
@endforeach

@endsection