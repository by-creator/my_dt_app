<div>
    <div class="card">
        <div class="card-header">
            <h4 class="card-title"><u>Formulaire ordre approche</u></h4>
        </div>
        <div class="card-content">
            <div class="card-body">
                @if($user->role->name == "ADMIN" )
                <form action="{{ route('ordre_approche.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                        <label>Importer Ordres d’approche (CSV)</label>

                        <div class="d-flex gap-2">
                            <input type="file" name="ordre_approche_file" class="form-control" accept=".xlsx, .xls, .csv"
                                required>

                            <button class="btn btn-primary" type="submit">
                                Importer
                            </button>
                        </div>
                    </div>
                </form>
                <hr>
                @endif
                <form method="POST" action="{{ route('ordre_approche.list') }}">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label for="date">Item number</label>
                                <div class="d-flex gap-2">

                                    <input list="ordres_list" name="ordre_id" class="form-control"
                                        placeholder="Saisir ou choisir un item" required>

                                    <datalist id="ordres_list">
                                        @foreach ($ordres as $ordre)
                                            <option value="{{ $ordre->item_number }}">
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
                <br>
            </div>
        </div>
    </div>
</div>
