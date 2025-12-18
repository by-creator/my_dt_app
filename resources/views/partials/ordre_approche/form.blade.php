<div>
    <div class="card">
        <div class="card-header">
            <h4 class="card-title"><u>Formulaire ordre approche</u></h4>
        </div>
        <div class="card-content">
            <div class="card-body">
                <form action="{{ route('ordre_approche.create') }}" method="post" target="_blank" class="form form-horizontal">
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
                            <div class="col-md-3 col-12">
                                <div class="form-group">
                                    <label for="date">Date</label>
                                    <input type="datetime-local" id="date" class="form-control" required
                                        name="date">
                                </div>
                            </div>
                            <div class="col-md-3 col-12">
                                <div class="form-group">
                                    <label for="chassis">Chassis</label>
                                    <input type="text" id="chassis" class="form-control"
                                        placeholder="Entrez une valeur pour chassis" required name="chassis">
                                </div>
                            </div>
                            <div class="col-md-3 col-12">
                                <div class="form-group">
                                    <label for="poids">Tranche de poids</label>
                                    <input type="text" id="poids" class="form-control"
                                        placeholder="Entrez une valeur pour poids" required name="poids">
                                </div>
                            </div>
                            <div class="col-md-3 col-12">
                                <div class="form-group">
                                    <label for="lane">Lane</label>
                                    <input type="text" id="lane" class="form-control"
                                        placeholder="Entrez une valeur pour lane" required name="lane">
                                </div>
                            </div>
                            <div class="col-md-3 col-12">
                                <div class="form-group">
                                    <label for="lane-number">Lane number</label>
                                    <input type="text" id="lane-number" class="form-control"
                                        placeholder="Entrez une valeur pour lane number" required name="lane_number">
                                </div>
                            </div>
                            <div class="col-md-3 col-12">
                                <div class="form-group">
                                    <label for="bae">N° BAE DOUANE</label>
                                    <input type="text" id="bae" class="form-control"
                                        placeholder="Entrez une valeur pour BAE" required name="bae">
                                </div>
                            </div>
                            <div class="col-md-3 col-12">
                                <div class="form-group">
                                    <label for="bae">BL / Booking</label>
                                    <input type="tex" id="bae" class="form-control" required
                                        placeholder="Entrez une valeur pour BL" name="booking">
                                </div>
                            </div>
                            <div class="col-md-3 col-12">
                                <div class="form-group">
                                    <label for="port">Port of loading</label>
                                    <input type="text" id="port" class="form-control" required
                                        placeholder="Entrez une valeur pour port" name="port">
                                </div>
                            </div>
                            <div class="col-md-3 col-12">
                                <div class="form-group">
                                    <label for="vessel">Vessel</label>
                                    <input type="text" id="vessel" class="form-control"
                                        placeholder="Entrez une valeur pour vessel" required name="vessel">
                                </div>
                            </div>
                            <div class="col-md-3 col-12">
                                <div class="form-group">
                                    <label for="call-number">Call Number</label>
                                    <input type="text" id="call-number" class="form-control"
                                        placeholder="Entrez une valeur pour call number" required name="call_number">
                                </div>
                            </div>
                            <div class="col-md-3 col-12">
                                <div class="form-group">
                                    <label for="vessel-arrival-date">Vessel arrival Date</label>
                                    <input type="datetime-local" id="vessel-arrival-date" class="form-control" required
                                        name="vessel_arrival_date">
                                </div>
                            </div>
                            <div class="col-md-3 col-12">
                                <div class="form-group">
                                    <label for="shipping-line">Shipping Line</label>
                                    <input type="text" id="shipping-line" class="form-control"
                                        placeholder="Entrez une valeur pour shipping line" required
                                        name="shipping_line">
                                </div>
                            </div>
                            <div class="col-md-3 col-12">
                                <div class="form-group">
                                    <label for="category">Category</label>
                                    <input type="text" id="category" class="form-control"
                                        placeholder="Entrez une valeur pour category" required name="category">
                                </div>
                            </div>
                            <div class="col-md-3 col-12">
                                <div class="form-group">
                                    <label for="type">Type</label>
                                    <input type="text" id="type" class="form-control"
                                        placeholder="Entrez une valeur pour type" required name="type">
                                </div>
                            </div>
                            <div class="col-md-3 col-12">
                                <div class="form-group">
                                    <label for="model">Model</label>
                                    <input type="text" id="model" class="form-control"
                                        placeholder="Entrez une valeur pour model" required name="model">
                                </div>
                            </div>
                            <div class="col-md-3 col-12">
                                <div class="form-group">
                                    <label for="client">Client Facturé</label>
                                    <input type="text" id="client" class="form-control"
                                        placeholder="Entrez une valeur pour client" required name="client">
                                </div>
                            </div>
                            <div class="col-md-3 col-12">
                                <div class="form-group">
                                    <label for="chauffeur">Nom Chauffeur</label>
                                    <input type="text" id="chauffeur" class="form-control"
                                        placeholder="Entrez une valeur pour chauffeur" required name="chauffeur">
                                </div>
                            </div>
                            <div class="col-md-3 col-12">
                                <div class="form-group">
                                    <label for="permis">N° Permis</label>
                                    <input type="text" id="permis" class="form-control"
                                        placeholder="Entrez une valeur pour permis" required name="permis">
                                </div>
                            </div>
                            <div class="col-md-3 col-12">
                                <div class="form-group">
                                    <label for="pointeur">Nom Pointeur Livreur</label>
                                    <input type="text" id="pointeur" class="form-control"
                                        placeholder="Entrez une valeur pour pointeur"  name="pointeur">
                                </div>
                            </div>
                            <div class="col-md-3 col-12">
                                <div class="form-group">
                                    <label for="responsable">Responsable Livraison</label>
                                    <input type="text" id="responsable" class="form-control"
                                        placeholder="Entrez une valeur pour responsable" name="responsable">
                                </div>
                            </div>
                            <div class="col-md-3 col-12">
                                <div class="form-group">
                                    <label for="reserve">Réserves</label>
                                    <textarea name="reserve" id="reserve" class="form-control" cols="30" rows="5"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary me-1 mb-1"><i
                                    class="fa-solid fa-check-to-slot"></i> Valider</button>
                            <button type="reset" class="btn btn-danger me-1 mb-1"><i
                                    class="fa-solid fa-square-xmark"></i> Annuler</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
