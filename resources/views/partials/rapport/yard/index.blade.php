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
            <div class="col-md-6 col-12">
                <form action="{{ route('yard.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                        <label>Importer les informations (CSV)</label>

                        <div class="d-flex gap-2">
                            <input type="file" name="file" class="form-control" accept=".xlsx, .xls, .csv"
                                required>

                            <button class="btn btn-primary" type="submit">
                                Importer
                            </button>
                        </div>
                    </div>
                </form>
                <hr>
            </div>
        </div>
    </div>
</div>
