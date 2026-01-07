<div>
    <div class="card">
        <div class="card-header">
            <h4 class="card-title"><u>Formulaire récap débarquement</u></h4>
        </div>
        <div class="card-content">
            <div class="card-body">
                <form action="{{ route('planification.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-3 col-12">
                            <div class="form-group">
                                <label for="date">Sélectionnez un fichier</label>
                                <div class="d-flex gap-2">
                                    <input class="form-control" type="file" name="file" required>
                                    <br>
                                    <button class="btn btn-primary" type="submit">Valider</button>
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
