<section id="poste-fixe-form">
    <div class="row match-height">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title"><u>Formulaire d'ajout de poste fixe</u></h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <form class="form" method="POST" action="{{ route('poste_fixes.create') }}">
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
                                        <label for="annuaire-column">Annuaire</label>
                                        <input type="text" id="annuaire-column" class="form-control"
                                            placeholder="Entrez l'annuaire" name="annuaire">
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="nom-column">Nom</label>
                                        <input type="text" id="nom-column" class="form-control"
                                            placeholder="Entrez le nom" name="nom">
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="prenom-column">Prénom</label>
                                        <input type="text" id="prenom-column" class="form-control"
                                            placeholder="Entrez le prénom" name="prenom">
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="type-poste-column">Type</label>
                                        <input type="text" id="type-poste-column" class="form-control"
                                            placeholder="Entrez le type" name="type">
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="entite-column">Entité</label>
                                        <input type="text" id="entite-column" class="form-control"
                                            placeholder="Entrez l'entité" name="entite">
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="role-column">Rôle</label>
                                        <input type="text" id="role-column" class="form-control"
                                            placeholder="Entrez le rôle" name="role">
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
