<form method="GET" action="{{ route('rattachement.index_remise') }}" class="row g-2 mb-3">

    <div class="col-md-2">
        <label class="form-label small">Numéro BL</label>
        <input type="text" class="form-control" name="bl" id="input-bl" list="datalist-bl"
            placeholder="Saisir un bl">

        <datalist id="datalist-bl"></datalist>

    </div>


    {{-- ➕ Ajoute les autres filtres ici --}}

    <div class="col-md-2 d-flex align-items-end">
        <button class="btn btn-sm btn-outline-primary me-2"><i class="fa-solid fa-filter"></i> Filtrer</button>
        <a href="{{ route('rattachement.index_remise') }}" class="btn btn-sm btn-outline-primary"><i class="fa-solid fa-rotate-right"></i> Actualiser</a>
    </div>
</form>
