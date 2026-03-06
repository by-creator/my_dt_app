@extends('partials.app')

@section('sidebar-menu')
    @include('partials.file_attente.menu')
@endsection

@section('content')
<style>
    body { background: #f5f7fb; }
    .form-container { max-width: 500px; margin: auto; padding: 40px 20px; }
    .card { background: white; border-radius: 20px; padding: 40px; box-shadow: 0 15px 35px rgba(0,0,0,.06); }
    label { font-weight: 600; margin-bottom: 6px; display: block; }
    input, select { width: 100%; padding: 12px; border-radius: 10px; border: 1px solid #e5e7eb; margin-bottom: 20px; }
    .actions { display: flex; gap: 10px; }
    .btn { padding: 12px; border-radius: 10px; font-weight: 600; text-decoration: none; border: none; width: 100%; }
    .btn-primary { background: #4f46e5; color: white; }
    .btn-secondary { background: #e5e7eb; color: #1e293b; }
</style>

<div class="form-container">
    <div class="card">
        <h2>➕ Nouvel agent</h2>

        <form method="POST" action="{{ route('agents.store') }}">
            @csrf

            <label>Nom du guichet</label>
            <input name="name" value="{{ old('name') }}" required>

            <label>Infos du guichet</label>
            <input name="info" value="{{ old('info') }}" required>

            <label>Service</label>
            <select name="service_id" required>
                <option value="">-- Choisir --</option>
                @foreach($services as $service)
                    <option value="{{ $service->id }}" {{ old('service_id') == $service->id ? 'selected' : '' }}>
                        {{ $service->name }}
                    </option>
                @endforeach
            </select>

            @if ($errors->any())
                <div class="alert alert-danger mb-3">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <div class="actions">
                <button class="btn btn-primary">Créer</button>
                <a href="{{ route('agents.index') }}" class="btn btn-secondary">Annuler</a>
            </div>
        </form>
    </div>
</div>
@endsection
