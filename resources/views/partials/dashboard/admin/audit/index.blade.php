<div class="col-md-12 col-12">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title"><u>Liste des claviers</u></h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
    <thead>
        <tr>
            <th>Date</th>
            <th>Utilisateur</th>
            <th>Rôle</th>
            <th>Action</th>
            <th>Détails</th>
            <th>IP</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($activities as $log)
            <tr>
                <td>{{ $log->created_at }}</td>
                <td>{{ optional($log->causer)->email }}</td>
                <td>{{ $log->properties['role']['name'] ?? '-' }}</td>
                <td>{{ $log->description }}</td>
                <td>
                    <pre>{{ json_encode($log->properties, JSON_PRETTY_PRINT) }}</pre>
                </td>
                <td>{{ $log->properties['ip'] ?? '-' }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

{{ $activities->links() }}
            </div>
        </div>
    </div>
</div>





