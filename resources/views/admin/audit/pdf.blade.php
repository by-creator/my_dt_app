<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 11px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #000; padding: 4px; }
        th { background: #f0f0f0; }
    </style>
</head>
<body>

<h3>Audit des activités</h3>

<table>
    <thead>
        <tr>
            <th>Date</th>
            <th>Utilisateur</th>
            <th>Action</th>
            <th>Rôle</th>
            <th>Méthode</th>
            <th>Route</th>
            <th>IP</th>
        </tr>
    </thead>
    <tbody>
        @foreach($activities as $log)
            <tr>
                <td>{{ $log->created_at->format('d/m/Y H:i:s') }}</td>
                <td>{{ optional($log->causer)->email ?? '-' }}</td>
                <td>{{ $log->description }}</td>
                <td>{{ data_get($log->properties, 'role.name') }}</td>
                <td>{{ data_get($log->properties, 'method') }}</td>
                <td>{{ data_get($log->properties, 'route') }}</td>
                <td>{{ data_get($log->properties, 'ip') }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>
