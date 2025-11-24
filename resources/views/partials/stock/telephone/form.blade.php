<div class="col-12">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title"><u>Formulaire d'ajout des postes téléphoniques</u></h4>
        </div>
        <div class="card-content">
            <div class="card-body">
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
                <form action="{{route('telephone-fixe.create')}}" method="post" id="userForm"
                    class="form form-horizontal">
                    @csrf
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-4">
                                 <label>Date de réception</label>
                             </div>
                             <div class="col-md-8">
                                 <div class="form-group has-icon-left">
                                     <div class="position-relative">
                                         <input name="date_reception" id="date_reception" type="datetime-local" class="form-control">
                                         <div class="form-control-icon">
                                             <i class="fa-solid fa-calendar"></i>
                                         </div>
                                     </div>
                                 </div>
                             </div>
                             <div class="col-md-4">
                                 <label>Date de déploiement</label>
                             </div>
                             <div class="col-md-8">
                                 <div class="form-group has-icon-left">
                                     <div class="position-relative">
                                         <input name="date_deploiement" id="date_deploiement" type="datetime-local" class="form-control">
                                         <div class="form-control-icon">
                                             <i class="fa-solid fa-calendar"></i>
                                         </div>
                                     </div>
                                 </div>
                             </div>
                            <div class="col-md-4">
                                <label>Annuaire</label>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group has-icon-left">
                                    <div class="position-relative">
                                        <input name="annuaire" id="annuaire" type="text" class="form-control"
                                            placeholder="Saisissez un annuaire" required>
                                        <div class="form-control-icon">
                                            <i class="fa-solid fa-file-signature"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label>Nom</label>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group has-icon-left">
                                    <div class="position-relative">
                                        <input name="nom" id="nom" type="text" class="form-control"
                                            placeholder="Saisissez un nom" required>
                                        <div class="form-control-icon">
                                            <i class="fa-solid fa-file-signature"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label>Prenom</label>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group has-icon-left">
                                    <div class="position-relative">
                                        <input name="prenom" id="prenom" type="text" class="form-control"
                                            placeholder="Saisissez un prenom" required>
                                        <div class="form-control-icon">
                                            <i class="fa-solid fa-file-signature"></i>
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
                                        <input name="type" id="type" type="text" class="form-control"
                                            placeholder="Saisissez un type" required>
                                        <div class="form-control-icon">
                                            <i class="fa-solid fa-file-signature"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label>Entite</label>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group has-icon-left">
                                    <div class="position-relative">
                                        <input name="entite" id="entite" type="text" class="form-control"
                                            placeholder="Saisissez une entite" value="130" required>
                                        <div class="form-control-icon">
                                            <i class="fa-solid fa-file-signature"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label>Role</label>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group has-icon-left">
                                    <div class="position-relative">
                                        <input name="role" id="role" type="text" class="form-control"
                                            placeholder="Saisissez un role" value="Défaut" required>
                                        <div class="form-control-icon">
                                            <i class="fa-solid fa-file-signature"></i>
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