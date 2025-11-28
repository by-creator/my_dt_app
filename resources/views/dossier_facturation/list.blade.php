@extends('partials.app')

@section('content')

<div class="container mt-4">

    <h2 class="mb-4">Documents du dossier</h2>

    <table class="table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Date Proforma</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($dossiers as $dossier)
            <tr>
                <td>{{ $dossier->id }}</td>
                <td>{{ $dossier->date_proforma }}</td>
                <td>
                    <a href="{{ route('dossier.show', $dossier->id) }}" class="btn btn-primary btn-sm">
                        Voir documents
                    </a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>


</div>

@endsection
