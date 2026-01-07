<div>
    <div class="card">
        <div class="card-header">
            <h4 class="card-title"><u>Formulaire ordre approche</u></h4>
        </div>
        <div class="card-content">
            <div class="card-body">
                <form method="POST" action="{{ route('ordre_approche.list') }}">
                    @csrf
                    <div class="row">
                        <div class="col-md-3 col-12">
                            <div class="form-group">
                                <label for="date">Item number</label>
                                <div class="d-flex gap-2">

                                    <input list="ordres_list" name="ordre_id" class="form-control"
                                        placeholder="Saisir ou choisir un item" required>

                                    <datalist id="ordres_list">
                                        @foreach ($ordres as $ordre)
                                            <option value="{{ $ordre->ItemNumber }}">
                                        @endforeach
                                    </datalist>

                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa-solid fa-check-to-slot"></i> Valider
                                    </button>

                                </div>
                            </div>
                        </div>
                    </div>
                </form>

                <form action="/import-operations" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="file" name="file" required>
                    <button type="submit">Importer et générer statistiques</button>
                </form>
                <br>
            </div>
        </div>
    </div>
</div>
