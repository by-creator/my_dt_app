<div class="card">
    <!-- Header -->
    <div class="card-header">
        <h4 class="card-title mb-0">
            <u>Formulaire Suivi Detail Facturation</u>
        </h4>
    </div>

    <!-- Body -->
    <div class="card-body">
        <div class="row">
            <!-- Formulaire 1 -->
            <div class="col-md-6 col-12">
                <form action="{{ route('rapport.infos_facturation.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label>Sélectionnez les informations depuis la source de données Facturation</label>
                        <div class="d-flex align-items-center gap-2">
                            <input class="form-control" type="file" name="facturation_file" required>
                            <button class="btn btn-primary" type="submit">
                                Valider
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Formulaire 2 -->
            <div class="col-md-6 col-12">
                <form action="{{ route('planification.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label>Sélectionnez les informations depuis la source de données Yard</label>
                        <div class="d-flex align-items-center gap-2">
                            <input class="form-control" type="file" name="yard_file" required>
                            <button class="btn btn-primary" type="submit">
                                Valider
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
