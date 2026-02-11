        <!-- Modal Modifier -->
<div class="modal fade" id="editModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <form id="editForm" method="POST">
            @csrf
            @method('PUT')

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">✏️ Modifier le téléphone mobile</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <input type="hidden" id="editId">

                    <div class="row">

                        <div class="col-md-3 mb-2">
                            <label>Matricule</label>
                            <input type="text" class="form-control" name="matricule" id="editMatricule">
                        </div>

                        <div class="col-md-3 mb-2">
                            <label>Nom</label>
                            <input type="text" class="form-control" name="nom" id="editNom">
                        </div>

                        <div class="col-md-3 mb-2">
                            <label>Prénom</label>
                            <input type="text" class="form-control" name="prenom" id="editPrenom">
                        </div>

                        <div class="col-md-3 mb-2">
                            <label>Service</label>
                            <input type="text" class="form-control" name="service" id="editService">
                        </div>

                        <div class="col-md-3 mb-2">
                            <label>Destination</label>
                            <input type="text" class="form-control" name="destination" id="editDestination">
                        </div>

                        <div class="col-md-3 mb-2">
                            <label>Référence téléphone</label>
                            <input type="text" class="form-control" name="reference_telephone" id="editReference">
                        </div>

                        <div class="col-md-3 mb-2">
                            <label>Ancien forfait TTC</label>
                            <input type="text" class="form-control"
                                   name="montant_ancien_forfait_ttc"
                                   id="editAncienForfait">
                        </div>

                        <div class="col-md-3 mb-2">
                            <label>Numéro SIM</label>
                            <input type="text" class="form-control" name="numero_sim" id="editNumeroSim">
                        </div>

                        <div class="col-md-3 mb-2">
                            <label>Formule premium</label>
                            <input type="text" class="form-control" name="formule_premium" id="editFormulePremium">
                        </div>

                        <div class="col-md-3 mb-2">
                            <label>Forfait TTC</label>
                            <input type="text" class="form-control" name="montant_forfait_ttc" id="editForfait">
                        </div>

                        <div class="col-md-3 mb-2">
                            <label>Code PUK</label>
                            <input type="text" class="form-control" name="code_puk" id="editCodePuk">
                        </div>

                        <div class="col-md-3 mb-2">
                            <label>Date acquisition</label>
                            <input type="date" class="form-control" name="acquisition_date" id="editAcquisitionDate">
                        </div>

                        <div class="col-md-3 mb-2">
                            <label>Statut</label>
                           <input type="text" class="form-control" name="statut" id="editStatut">
                        </div>

                        <div class="col-md-6 mb-2">
                            <label>Cause du changement</label>
                            <input type="text" class="form-control" name="cause_changement" id="editCause">
                        </div>

                        <div class="col-md-6 mb-2">
                            <label>IMSI</label>
                            <input type="text" class="form-control" name="imsi" id="editImsi">
                        </div>

                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-outline-primary">
                        💾 Enregistrer
                    </button>
                    <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-dismiss="modal">
                        Fermer
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
