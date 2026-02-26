<div class="table-responsive">
    <table class="table table-striped" id="tableRemises">
        <thead>
            <tr>
                <th>Date de création</th>
                <th>Client</th>
                <th>Email</th>
                <th>BL</th>
                <th>Statut</th>
                
                
            </tr>
        </thead>
        <tbody>
            @foreach ($remisesTraitees as $remise)
                <tr>
                    <td>{{ optional($remise->created_at)->format('d/m/Y H:i') }}</td>
                    <td>{{ $remise->nom }} {{ $remise->prenom }}</td>
                    <td>{{ $remise->email }}</td>
                    <td>{{ $remise->bl }}</td>
                    <td>{{ $remise->statut }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>