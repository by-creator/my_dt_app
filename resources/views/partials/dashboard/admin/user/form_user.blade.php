<div>
    <div class="card">
        <div class="card-header">
            <h4 class="card-title"><u>Formulaire d'ajout des utilisateurs</u></h4>
        </div>
        <div class="card-content">
            <div class="card-body">
                <form action="{{route('user.create')}}" method="post" class="form form-horizontal">
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
                                <label>Rôle</label>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group has-icon-left">
                                    <div class="position-relative">
                                        <select name="role_id" id="role_id" class="form-control" required>
                                            <option value="">Choisissez un role</option>
                                            @foreach($roles as $role)
                                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                                            @endforeach
                                        </select>
                                        <div class="form-control-icon">
                                            <i class="fa-solid fa-user-lock"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label>Nom complet (Nom & Prénom)</label>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group has-icon-left">
                                    <div class="position-relative">
                                        <input name="name" id="name" type="text" class="form-control"
                                            placeholder="Saisissez votre nom et prénom" required>
                                        <div class="form-control-icon">
                                            <i class="fa-solid fa-file-signature"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label>Email</label>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group has-icon-left">
                                    <div class="position-relative">
                                        <input name="email" id="username" type="email"
                                            class="form-control" placeholder="Saisissez votre adresse mail" required>
                                        <div class="form-control-icon">
                                            <i class="fa-solid fa-envelope"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label>Numéro de téléphone)</label>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group has-icon-left">
                                    <div class="position-relative">
                                        <input name="telephone" id="telephone" type="number" class="form-control"
                                            placeholder="Saisissez votre numéro de téléphone" required>
                                        <div class="form-control-icon">
                                            <i class="fa-solid fa-phone"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label>Mot de passe</label>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group has-icon-left">
                                    <div class="position-relative">
                                        <input name="password" id="password" type="password"
                                            class="form-control" placeholder="Saisissez un mot de passe" required>
                                        <div class="form-control-icon">
                                            <i class="fa-solid fa-lock"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <label>Confirmez votre mot de passe</label>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group has-icon-left">
                                    <div class="position-relative">
                                        <input name="password_confirmation" id="password_confirmation" type="password"
                                            class="form-control" placeholder="Saisissez à nouveau votre mot de passe" required>
                                        <div class="form-control-icon">
                                            <i class="fa-solid fa-lock"></i>
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