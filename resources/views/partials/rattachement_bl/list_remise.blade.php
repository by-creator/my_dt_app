<section class="section">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title"><u>Liste des remises</u></h4>
        </div>
        <div class="card-body">
            <table class="table table-striped" id="table1">
                <thead>
                    <tr>
                        <th>Date & Heure</th>
                        <th>Nom & Prénom</th>
                        <th>Email</th>
                        <th>BL</th>
                        <th>Statut</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($rattachements as $rattachement)
                    <tr>
                        <td>{{ $rattachement->created_at_date_formatted ?? '—' }}</td>
                        
                        <td>{{ $rattachement->nom }} {{ $rattachement->prenom }}</td>
                        <td>{{ $rattachement->email }}</td>
                        <td>{{ $rattachement->bl }}</td>
                        <td>{{ $rattachement->statut }}</td>

                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

</section>