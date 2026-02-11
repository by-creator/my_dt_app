<form method="GET" action="{{ route('telephone-mobiles.index') }}" class="row g-2 mb-3">

    <div class="col-md-2">
        <label class="form-label small">Matricule</label>
        <input list="matricule" name="matricule" class="form-control"
               placeholder="Saisir un matricule"
               value="{{ request('matricule') }}">

        <datalist id="matricule">
            @foreach ($telephones as $telephone)
                <option value="{{ $telephone->matricule }}">
            @endforeach
        </datalist>
    </div>

    <div class="col-md-2">
        <label class="form-label small">Nom</label>
        <input list="nom" name="nom" class="form-control"
               placeholder="Saisir un nom"
               value="{{ request('nom') }}">

        <datalist id="nom">
            @foreach ($telephones as $telephone)
                <option value="{{ $telephone->nom }}">
            @endforeach
        </datalist>
    </div>

    {{-- ➕ Ajoute les autres filtres ici --}}

    <div class="col-md-2 d-flex align-items-end">
        <button class="btn btn-sm btn-outline-primary me-2">🔍 Filtrer</button>
        <a href="{{ route('telephone-mobiles.index') }}"
           class="btn btn-sm btn-outline-success">♻️</a>
    </div>
</form>
