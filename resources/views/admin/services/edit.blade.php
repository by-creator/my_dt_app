@extends('layouts.app')

@section('content')
<style>
    body { background: #f5f7fb; }
    .form-container { max-width: 500px; margin: auto; padding: 40px 20px; }
    .card { background: white; border-radius: 20px; padding: 40px; box-shadow: 0 15px 35px rgba(0,0,0,.06); }
    label { font-weight: 600; margin-bottom: 6px; display: block; }
    input { width: 100%; padding: 12px; border-radius: 10px; border: 1px solid #e5e7eb; margin-bottom: 20px; }
    .actions { display: flex; gap: 10px; }
    .btn { padding: 12px; border-radius: 10px; font-weight: 600; text-decoration: none; border: none; width: 100%; }
    .btn-primary { background: #4f46e5; color: white; }
    .btn-secondary { background: #e5e7eb; color: #1e293b; }
</style>

<div class="form-container">
    <div class="card">
        <h2>✏️ Modifier le service</h2>

        <form method="POST" action="{{ route('services.update', $service) }}">
            @csrf @method('PUT')

            <label>Nom du service</label>
            <input name="name" value="{{ old('name', $service->name) }}" required>

            <label>Préfixe</label>
            <input name="prefix" value="{{ old('prefix', $service->prefix) }}" required>

            @if ($errors->any())
                <div class="alert alert-danger mb-3">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <div class="actions">
                <button class="btn btn-primary">Mettre à jour</button>
                <a href="{{ route('services.index') }}" class="btn btn-secondary">Annuler</a>
            </div>
        </form>
    </div>
</div>
@endsection
