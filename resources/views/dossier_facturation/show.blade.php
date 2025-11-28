@extends('partials.app')

@section('content')

<div class="container mt-4">

    <h2 class="mb-4">Documents du dossier</h2>

    <table class="table table-bordered">
        <tr>
            <th>Proforma</th>
            <td>
                @if ($dossier->proforma)
                    <a href="{{ asset('storage/' . $dossier->proforma) }}" target="_blank">
                        {{ $dossier->proforma_original_name }}
                    </a>
                @else
                    <span class="text-muted">Pas de fichier</span>
                @endif
            </td>
        </tr>

        <tr>
            <th>Facture</th>
            <td>
                @if ($dossier->facture)
                    <a href="{{ asset('storage/' . $dossier->facture) }}" target="_blank">
                        {{ $dossier->facture_original_name }}
                    </a>
                @else
                    <span class="text-muted">Pas de fichier</span>
                @endif
            </td>
        </tr>

        <tr>
            <th>Bon</th>
            <td>
                @if ($dossier->bon)
                    <a href="{{ asset('storage/' . $dossier->bon) }}" target="_blank">
                        {{ $dossier->bon_original_name }}
                    </a>
                @else
                    <span class="text-muted">Pas de fichier</span>
                @endif
            </td>
        </tr>
    </table>

</div>

@endsection
