@extends('partials.app')

@section('content')
<div class="container">
    <h2>Liste des dossiers</h2>

    @if($dossiers->isEmpty())
    <p>Aucun dossier enregistré.</p>
    @else
    <table border="1" cellpadding="8" cellspacing="0">
        <tr>
            <th>ID</th>
            <th>Date Proforma</th>
            <th>Proforma</th>
            <th>Facture</th>
            <th>Bon</th>
            <th>Actions</th>
        </tr>
        @foreach($dossiers as $dossier)
        <tr>
            <td>{{ $dossier->id }}</td>
            <td>{{ optional($dossier->date_proforma)?->format('d/m/Y') ?? '—' }}</td>

            {{-- Affiche nombre de fichiers pour chaque type --}}
            <td>{{ count($dossier->proforma ?? []) }} fichier(s)</td>
            <td>{{ count($dossier->facture ?? []) }} fichier(s)</td>
            <td>{{ count($dossier->bon ?? []) }} fichier(s)</td>

            <td>
                <a href="{{ route('dossier_facturation.show', $dossier->id) }}" class="btn btn-sm btn-primary">
                    Voir
                </a>
            </td>
        </tr>
        @endforeach
    </table>
    @endif
</div>
@endsection