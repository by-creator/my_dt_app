<div class="card">
    <div class="card-header">
        <h4 class="card-title"><u>Informations société</u></h4>
    </div>
    <div class="card-content">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <label>Directeur Général</label>
                </div>
                <div class="col-md-8">
                    <div class="form-group has-icon-left">
                        <div class="position-relative">
                            <input type="text" id="name-column" class="form-control"
                                placeholder="Saisissez le nom du Directeur Général" name="dg">
                            <div class="form-control-icon">
                                👤
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <label>Numéro de téléphone</label>
                </div>
                <div class="col-md-8">
                    <div class="form-group has-icon-left">
                        <div class="position-relative">
                            <input type="text" id="telephone-column" class="form-control" placeholder="Saisissez son numéro de téléphone" name="dg_phone">
                            <div class="form-control-icon">
                                📱
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <label>Directeur Financier</label>
                </div>
                <div class="col-md-8">
                    <div class="form-group has-icon-left">
                        <div class="position-relative">
                            <input type="text" id="name-column" class="form-control"
                                placeholder="Saisissez le nom du Directeur Financier" name="daf">
                            <div class="form-control-icon">
                                👤
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <label>Numéro de téléphone</label>
                </div>
                <div class="col-md-8">
                    <div class="form-group has-icon-left">
                        <div class="position-relative">
                            <input type="text" id="telephone-column" class="form-control" placeholder="Saisissez son numéro de téléphone" name="daf_phone">
                            <div class="form-control-icon">
                               📱
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
        @include('partials.facturation.society_infos_plus')
</div>