
<h2>Liste des dossiers</h2>

@if($dossiers->isEmpty())
    <p>Aucun dossier enregistré.</p>
@else
<table border="1">
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
        <td>{{ $dossier->date_proforma?->format('d/m/Y') }}</td>
        <td>{{ $dossier->proforma_original_name ?? '—' }}</td>
        <td>{{ $dossier->facture_original_name ?? '—' }}</td>
        <td>{{ $dossier->bon_original_name ?? '—' }}</td>
        <td>
            <a href="{{ route('dossier_facturation.show', $dossier->id) }}">Voir</a>
        </td>
    </tr>
    @endforeach
</table>
@endif
