<div>
    <div class="card">
        <div class="card-header">
            <h4 class="card-title"><u>Formulaire de gestion des items</u></h4>
        </div>
        <div class="card-content">
            <div class="card-body">
                @if ($user->role->name == 'ADMIN')
                    <form action="{{ route('yard.import') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group">
                            <label>Importer les informations (CSV)</label>

                            <div class="d-flex gap-2">
                                <input type="file" name="ordre_approche_file" class="form-control"
                                    accept=".xlsx, .xls, .csv" required>

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
                        <div class="col-md-6 ">
                            <div class="form-group">
                                <label for="date">Item number</label>
                                <div class="d-flex gap-2">

                                    <input list="ordres_list" name="ItemNumber" class="form-control"
                                        placeholder="Saisir ou choisir un item" required>

                                    <datalist id="ordres_list">
                                        @foreach ($itemNumbers as $itemNumber)
                                            <option value="{{ $itemNumber }}">
                                        @endforeach
                                    </datalist>
                                    <div class="col-md-6 d-flex align-items-end">
                                        <button type="submit" class="btn btn-sm btn-outline-primary me-2">
                                            🔒 Bloquer
                                        </button>
                                        <button type="submit" class="btn btn-sm btn-outline-primary me-2">
                                            🔓 Débloquer
                                        </button>
                                    </div>
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
