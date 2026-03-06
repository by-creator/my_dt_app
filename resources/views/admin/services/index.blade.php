@extends('layouts.app')

@section('content')
<style>
    body { background: #f5f7fb; }

    .admin-container { max-width: 900px; margin: auto; padding: 30px 20px; }

    .card { background: white; border-radius: 20px; padding: 30px; box-shadow: 0 15px 35px rgba(0,0,0,.06); }

    .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; }
    .header h2 { font-weight: 700; color: #1e293b; }

    table { width: 100%; border-collapse: collapse; }
    th, td { padding: 14px; text-align: left; }
    th { background: #f1f5f9; color: #475569; }
    tr:not(:last-child) td { border-bottom: 1px solid #e5e7eb; }

    .actions a, .actions button { margin-right: 6px; }

    .btn { padding: 8px 14px; border-radius: 8px; font-weight: 600; text-decoration: none; border: none; }
    .btn-primary { background: #4f46e5; color: white; }
    .btn-warning { background: #f59e0b; color: white; }
    .btn-danger  { background: #ef4444; color: white; }
</style>

<div class="admin-container">
    <div class="card">
        <div class="header">
            <h2>🛠️ Services</h2>
            <a href="{{ route('services.create') }}" class="btn btn-primary">➕ Nouveau service</a>
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table>
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Préfixe</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            @foreach($services as $service)
                <tr>
                    <td>{{ $service->name }}</td>
                    <td><strong>{{ $service->prefix }}</strong></td>
                    <td class="actions">
                        <a href="{{ route('services.edit', $service) }}" class="btn btn-warning">✏️</a>
                        <form method="POST" action="{{ route('services.destroy', $service) }}" style="display:inline">
                            @csrf @method('DELETE')
                            <button class="btn btn-danger">🗑️</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
