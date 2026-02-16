<form method="GET" action="{{ route('yard.index') }}" class="row g-2 mb-3">

    <div class="col-md-2">
        <label class="form-label small">Item Number</label>
        <input type="text" class="form-control" name="item_number" id="input-item_number" list="datalist-item_number"
            placeholder="Saisir un item_number">

        <datalist id="datalist-item_number"></datalist>

    </div>


    {{-- ➕ Ajoute les autres filtres ici --}}

    <div class="col-md-2 d-flex align-items-end">
        <button class="btn btn-sm btn-outline-primary me-2"><i class="fa-solid fa-filter"></i> Filtrer</button>
        <a href="{{ route('yard.index') }}" class="btn btn-sm btn-outline-primary"><i class="fa-solid fa-rotate-right"></i> Actualiser</a>
    </div>
</form>
