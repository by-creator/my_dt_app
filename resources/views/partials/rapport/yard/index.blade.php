<div class="card">
    <!-- Header -->
    <div class="card-header">
        <h4 class="card-title mb-0">
            <u>Formulaire Suivi Yard</u>
        </h4>
    </div>

    <!-- Body -->
    <div class="card-body">
        <div class="row">
            <!-- Formulaire 1 -->
            <div class="col-md-12 col-12">
                <form action="{{ route('yard.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                        <label>Importer des données Yard</label>

                        <div class="row">
                            <div class="col-md-6 col-12">
                                <input type="file" name="file" class="form-control" accept=".xlsx,.xls,.csv"
                                    required>
                            </div>

                            <div class="col-md-3 col-12 d-flex align-items-end">
                                <button class="btn btn-sm btn-outline-primary w-100 me-2" type="submit">
                                    <i class="fa-solid fa-upload"></i> Importer
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
                <hr>
            </div>
        </div>
    </div>
</div>
