<section id="machine-form">
    <div class="row match-height">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title"><u>Formulaire d'ajout de machine</u></h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <form class="form" method="POST" action="{{ route('machines.create') }}">
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
                            <div class="row">
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="numero-serie-column">Numéro de série</label>
                                        <input type="text" id="numero-serie-column" class="form-control"
                                            placeholder="Entrez le numéro de série" name="numero_serie">
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="modele-column">Modèle</label>
                                        <input type="text" id="modele-column" class="form-control"
                                            placeholder="Entrez le modèle" name="modele">
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="type-machine-column">Type</label>
                                        <input type="text" id="type-machine-column" class="form-control"
                                            placeholder="Entrez le type" name="type">
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="utilisateur-column">Utilisateur</label>
                                        <input type="text" id="utilisateur-column" class="form-control"
                                            placeholder="Entrez l'utilisateur" name="utilisateur">
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="service-machine-column">Service</label>
                                        <input type="text" id="service-machine-column" class="form-control"
                                            placeholder="Entrez le service" name="service">
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="site-column">Site</label>
                                        <input type="text" id="site-column" class="form-control"
                                            placeholder="Entrez le site" name="site">
                                    </div>
                                </div>
                                <div class="col-12 d-flex justify-content-end">
                                    <button type="submit"
                                        class="btn btn-primary me-1 mb-1"><i class="fa-solid fa-check-to-slot"></i> Valider</button>
                                    <button type="reset"
                                        class="btn btn-danger me-1 mb-1"><i class="fa-solid fa-square-xmark"></i> Annuler</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
