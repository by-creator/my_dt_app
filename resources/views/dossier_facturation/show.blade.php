@extends('partials.app')

@section('content')

<tr>
    <th>Proforma</th>
    <td>
        @if ($dossier->proforma)
        @foreach ($dossier->proforma as $file)
        @if (!empty($file['path']) && $file['path'] !== false)
        <a href="{{ Storage::disk('b2')->url($file['path']) }}" target="_blank">
            {{ $file['original'] }}
        </a>
        @else
        <span class="text-danger">⚠️ Fichier non disponible</span>
        @endif
        @endforeach



        @endif
    </td>
</tr>

<tr>
    <th>Facture</th>
    <td>
        @if ($dossier->facture)
        @foreach ($dossier->facture as $file)
        @if (!empty($file['path']) && $file['path'] !== false)
        <a href="{{ Storage::disk('b2')->url($file['path']) }}" target="_blank">
            {{ $file['original'] }}
        </a>
        @else
        <span class="text-danger">⚠️ Fichier non disponible</span>
        @endif
        @endforeach



        @endif
    </td>
</tr>

<tr>
    <th>Bon</th>
    <td>
        @if ($dossier->bon)
        @foreach ($dossier->proforma as $file)
        @if (!empty($file['path']) && $file['path'] !== false)
        <a href="{{ Storage::disk('b2')->url($file['path']) }}" target="_blank">
            {{ $file['original'] }}
        </a>
        @else
        <span class="text-danger">⚠️ Fichier non disponible</span>
        @endif
        @endforeach



        @endif
    </td>
</tr>



@endsection