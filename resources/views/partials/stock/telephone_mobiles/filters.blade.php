<form method="GET" action="{{ route('telephone-mobiles.index') }}" class="row g-2 mb-3">

    <div class="col-md-2">
        <label class="form-label small">Matricule</label>
        <input type="text" class="form-control" name="matricule" id="input-matricule" list="datalist-matricule"
            placeholder="Saisir un matricule">

        <datalist id="datalist-matricule"></datalist>

    </div>

    <div class="col-md-2">
        <label class="form-label small">Nom</label>
        <input type="text" class="form-control" name="nom" id="input-nom" list="datalist-nom"
            placeholder="Saisir un nom">

        <datalist id="datalist-nom"></datalist>
    </div>

    <div class="col-md-2">
        <label class="form-label small">Prénom</label>
        <input type="text" class="form-control" name="prenom" id="input-prenom" list="datalist-prenom"
            placeholder="Saisir un prénom">

        <datalist id="datalist-prenom"></datalist>
    </div>

    <div class="col-md-2">
        <label class="form-label small">Numéro SIM</label>
        <input type="text" class="form-control" name="numero_sim" id="input-sim" list="datalist-sim"
            placeholder="Saisir un numéro SIM">

        <datalist id="datalist-sim"></datalist>
    </div>



    {{-- ➕ Ajoute les autres filtres ici --}}

    <div class="col-md-2 d-flex align-items-end">
        <button class="btn btn-sm btn-outline-primary me-2"><i class="fa-solid fa-filter"></i> Filtrer</button>
        <a href="{{ route('telephone-mobiles.index') }}" class="btn btn-sm btn-outline-primary"><i class="fa-solid fa-rotate-right"></i> Actualiser</a>
    </div>
</form>
