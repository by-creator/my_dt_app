<div>
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Formulaire d'ajout de proforma</h4>
        </div>
        <div class="card-content">
            <div class="card-body">
                <form action="{{route('proforma.store')}}" method="post" class="form form-horizontal" enctype="multipart/form-data">
                    @csrf
                    @if (session('create'))
                    <script>
                        Swal.fire({
                            icon: 'success',
                            title: 'Ajout',
                            text: "{{ session('create') }}",
                            showConfirmButton: true
                        });
                    </script>
                    @endif
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-4">
                                <label>Numéro BL</label>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group has-icon-left">
                                    <div class="position-relative">
                                        <input type="text" name="bl" class="form-control" require placeholder="Entrez le BL" id="first-name-icon">
                                        <div class="form-control-icon">
                                            <i class="fa-solid fa-user-lock"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label>Numéro de compte client</label>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group has-icon-left">
                                    <div class="position-relative">
                                        <input type="text" name="account" class="form-control" require placeholder="Entrez le compte du client" id="first-name-icon">
                                        <div class="form-control-icon">
                                            <i class="fa-solid fa-user-lock"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-12">
                                <div class="card">
                                    <div class="card-content">
                                        <div class="card-body">
                                            <p class="card-text">Veuillez importer le connaissement et la déclaration
                                            </p>
                                            <!-- File uploader with multiple files upload -->
                                            <input type="file" name="files[]" class="multiple-files-filepond" require multiple>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 d-flex justify-content-end">
                                <button type="submit"
                                    class="btn btn-primary me-1 mb-1">Valider</button>
                                <button type="reset"
                                    class="btn btn-light-secondary me-1 mb-1">Annuler</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>