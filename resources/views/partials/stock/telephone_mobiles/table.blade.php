<div class="table-responsive">
    <table class="table table-striped" id="tableTelephones">
        <thead>
            <tr>
                <th>Date</th>
                <th>Matricule</th>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Service</th>
                <th>SIM</th>
                <th>Statut</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($telephones as $telephone)
                <tr>
                    <td>{{ optional($telephone->acquisition_date)->format('d/m/Y') }}</td>
                    <td>{{ $telephone->matricule }}</td>
                    <td>{{ $telephone->nom }}</td>
                    <td>{{ $telephone->prenom }}</td>
                    <td>{{ $telephone->service }}</td>
                    <td>{{ $telephone->numero_sim }}</td>
                    <td>{{ $telephone->statut }}</td>
                    <td>
                        @include('partials.stock.telephone_mobiles.table-actions')
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
