<section class="section">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title"><u>Liste des demandes de validation</u></h4>
        </div>
        <div class="card-body">
            <table class="table table-striped" id="table1">
                <thead>
                    <tr>
                        <th>Date & Heure</th>
                        <th>Agent</th>
                        <th>Nom & Prénom</th>
                        <th>BL</th>
                        <th>Compte</th>
                        <th>Statut</th>
                        <th>Durée</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($rattachements as $rattachement)
                    <tr>
                        <td>{{ $rattachement->created_at_date_formatted ?? '—' }}</td>
                        <td>
                            @php
                            $user = $users->firstWhere('id', $rattachement->user_id);
                            @endphp
                            {{ $user ? $user->name : 'Agent non défini' }}
                        </td>
                        <td>{{ $rattachement->nom }} {{ $rattachement->prenom }}</td>
                        <td>{{ $rattachement->bl }}</td>
                        <td>{{ $rattachement->compte }}</td>
                        <td>{{ $rattachement->statut }}</td>
                        <td>{{ $rattachement->time_elapsed }}</td>
                        
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

</section>