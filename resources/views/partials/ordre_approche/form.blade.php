<div>
    <div class="card">
        <div class="card-header">
            <h4 class="card-title"><u>Formulaire ordre approche</u></h4>
        </div>
        <div class="card-content">
            <div class="card-body">
                <form action="{{route('ordre_approche.create')}}" method="post" class="form form-horizontal">
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
                                <label>Date</label>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group has-icon-left">
                                    <div class="position-relative">
                                        <input name="date" id="date" type="text" class="form-control"
                                            placeholder="Saisissez la date" required>
                                        <div class="form-control-icon">
                                            <i class="fa-solid fa-calendar"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label>Numéro</label>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group has-icon-left">
                                    <div class="position-relative">
                                        <input name="numero" id="numero" type="text"
                                            class="form-control" placeholder="Saisissez le numéro" required>
                                        <div class="form-control-icon">
                                            <i class="fa-solid fa-arrow-down-1-9"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label>Client facturé</label>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group has-icon-left">
                                    <div class="position-relative">
                                        <input name="client" id="client" type="text"
                                            class="form-control" placeholder="Saisissez le client facturé" required>
                                        <div class="form-control-icon">
                                            <i class="fa-solid fa-user"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label>Type</label>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group has-icon-left">
                                    <div class="position-relative">
                                        <select class="form-control" name="type" id="type" required>
                                            <option value="">Sélectionnez un type</option>
                                            <option value="VEHICULE">VEHICULE</option>
                                            <option value="CONTENEUR">CONTENEUR</option>
                                            <option value="GK">GK</option>
                                        </select>
                                        <div class="form-control-icon">
                                            <i class="fa-solid fa-file"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary me-1 mb-1"><i class="fa-solid fa-check-to-slot"></i> Valider</button>
                                <button type="reset" class="btn btn-danger me-1 mb-1"><i class="fa-solid fa-square-xmark"></i> Annuler</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>