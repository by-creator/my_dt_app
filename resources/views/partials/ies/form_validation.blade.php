<div class="card">
    <div class="card-header">
        <h4 class="card-title"><u>Informations de validation</u></h4>
    </div>
    <div class="card-content">
        <div class="card-body">
            <div class="row">

                {{-- Utilisateur --}}
                <div class="col-md-4">
                    <label>Agent demandeur</label>
                </div>
                <div class="col-md-8">
                    <div class="form-group has-icon-left">
                        <div class="position-relative">
                            <select name="user_id" id="user_id" class="form-control" required>
                                <option value="">-- Sélectionnez un utilisateur --</option>
                                @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                            <div class="form-control-icon">
                                <i class="fa-solid fa-user"></i>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Email --}}
                <div class="col-md-4">
                    <label>Email</label>
                </div>
                <div class="col-md-8">
                    <div class="form-group has-icon-left">
                        <div class="position-relative">
                            <input required type="email" name="email" id="email-column" class="form-control" placeholder="Saisissez une adresse mail">
                            <div class="form-control-icon">
                                <i class="fa-solid fa-envelope"></i>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Statut --}}
                <div class="col-md-4">
                    <label>Statut</label>
                </div>
                <div class="col-md-8">
                    <div class="form-group has-icon-left">
                        <div class="position-relative">
                            <select name="statut" id="statut" class="form-control" required>
                                <option value="">-- Sélectionnez un statut --</option>
                                <option value="VALIDE">VALIDE</option>
                                <option value="INVALIDE">INVALIDE</option>
                            </select>
                            <div class="form-control-icon">
                                <i class="fa-solid fa-check-double"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>