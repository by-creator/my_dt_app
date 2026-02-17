<div>
    <div class="card">
        <div class="card-header">
            <h4 class="card-title"><u>Formulaire ordre approche</u></h4>
        </div>
        <div class="card-content">
            <div class="card-body">
                <form action="{{ route('ordre_approche.update', ['id' => $ordre->id]) }}" method="POST" target="_blank"
                    class="form form-horizontal">
                    @csrf

                    @if (session('update'))
                        <script>
                            Swal.fire({
                                icon: 'success',
                                title: 'Modification',
                                text: "{{ session('update') }}",
                                showConfirmButton: true
                            });
                        </script>
                    @endif
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-2 col-12">
                                <div class="form-group">
                                    <label for="item_number">Item Number</label>
                                    <input type="text" id="item_number" class="form-control"
                                        placeholder="Entrez une valeur pour item_number" required name="item_number"
                                        value="{{ $ordre->item_number ?? '' }}">
                                </div>
                            </div>
                            <div class="col-md-2 col-12">
                                <div class="form-group">
                                    <label for="zone">Zone</label>
                                    <input type="text" id="zone" class="form-control"
                                        placeholder="Entrez une valeur pour zone" required name="zone"
                                        value="{{ $ordre->zone ?? '' }}">
                                </div>
                            </div>
                            <div class="col-md-2 col-12">
                                <div class="form-group">
                                    <label for="type_de_marchandise">Type De Marchandise</label>
                                    <input type="text" id="type_de_marchandise" class="form-control"
                                        placeholder="Entrez une valeur pour type_de_marchandise" required
                                        name="type_de_marchandise" value="{{ $ordre->type_de_marchandise ?? '' }}">
                                </div>
                            </div>
                            <div class="col-md-2 col-12">
                                <div class="form-group">
                                    <label for="bl_number">Bl Number</label>
                                    <input type="text" id="bl_number" class="form-control" required
                                        placeholder="Entrez une valeur pour BL" name="bl_number"
                                        value="{{ $ordre->bl_number ?? '' }}">
                                </div>
                            </div>
                            <div class="col-md-2 col-12">
                                <div class="form-group">
                                    <label for="vessel">Vessel</label>
                                    <input type="text" id="vessel" class="form-control" required
                                        placeholder="Entrez une valeur pour Vessel" name="vessel"
                                        value="{{ $ordre->vessel ?? '' }}">
                                </div>
                            </div>
                            <div class="col-md-2 col-12">
                                <div class="form-group">
                                    <label for="call_number">Call Number</label>
                                    <input type="text" id="call_number" class="form-control" required
                                        placeholder="Entrez une valeur pour call number" name="call_number"
                                        value="{{ $ordre->call_number ?? '' }}">
                                </div>
                            </div>
                            <div class="col-md-2 col-12">
                                <div class="form-group">
                                    <label for="vessel_arrival_date">Vessel Arrival Date</label>
                                    <input type="text" id="vessel_arrival_date" class="form-control" required
                                        placeholder="Entrez une valeur pour vessel arrival date"
                                        name="vessel_arrival_date"
                                        value="{{ $ordre->vessel_arrival_date->format('d-m-Y') ?? '' }}">
                                </div>
                            </div>
                            <div class="col-md-2 col-12">
                                <div class="form-group">
                                    <label for="shipowner">Shipowner</label>
                                    <input type="text" id="shipowner" class="form-control"
                                        placeholder="Entrez une valeur pour shipping line" required name="shipowner"
                                        value="{{ $ordre->shipowner ?? '' }}">
                                </div>
                            </div>
                            <div class="col-md-2 col-12">
                                <div class="form-group">
                                    <label for="item_code">Item Code</label>
                                    <input type="text" id="item_code" class="form-control"
                                        placeholder="Entrez une valeur pour Item_Code" required name="item_code"
                                        value="{{ $ordre->item_code ?? '' }}">
                                </div>
                            </div>
                            <div class="col-md-2 col-12">
                                <div class="form-group">
                                    <label for="item_type">Item Type</label>
                                    <input type="text" id="item_type" class="form-control"
                                        placeholder="Entrez une valeur pour Item_Type" required name="item_type"
                                        value="{{ $ordre->item_type ?? '' }}">
                                </div>
                            </div>
                            <div class="col-md-2 col-12">
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <input type="text" id="description" class="form-control"
                                        placeholder="Entrez une valeur pour description" required name="description"
                                        value="{{ $ordre->description ?? '' }}">
                                </div>
                            </div>
                            <div class="col-md-2 col-12">
                                <div class="form-group">
                                    <label for="bae">BAE DOUANE</label>
                                    <input type="text" id="bae" class="form-control"
                                        placeholder="Entrez une valeur pour bae" required name="bae"
                                        value="{{ $ordre->bae ?? '' }}">
                                </div>
                            </div>
                            <div class="col-md-2 col-12">
                                <div class="form-group">
                                    <label for="consignee">Client Facturé</label>
                                    <input type="text" id="consignee" class="form-control"
                                        placeholder="Entrez une valeur pour consignee" required name="consignee"
                                        value="{{ $ordre->consignee ?? '' }}">
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-2 col-12">
                                <div class="form-group">
                                    <label for="chauffeur">Nom Chauffeur</label>
                                    <input type="text" id="chauffeur" class="form-control"
                                        placeholder="Entrez une valeur pour chauffeur" name="chauffeur">
                                </div>
                            </div>
                            <div class="col-md-2 col-12">
                                <div class="form-group">
                                    <label for="permis">N° Permis</label>
                                    <input type="text" id="permis" class="form-control"
                                        placeholder="Entrez une valeur pour permis" name="permis">
                                </div>
                            </div>
                            <div class="col-md-2 col-12">
                                <div class="form-group">
                                    <label for="pointeur">Nom Pointeur Livreur</label>
                                    <input type="text" id="pointeur" class="form-control"
                                        placeholder="Entrez une valeur pour pointeur" name="pointeur">
                                </div>
                            </div>
                            <div class="col-md-2 col-12">
                                <div class="form-group">
                                    <label for="responsable">Responsable Livraison</label>
                                    <input type="text" id="responsable" class="form-control"
                                        placeholder="Entrez une valeur pour responsable" name="responsable">
                                </div>
                            </div>
                            <div class="col-md-2 col-12">
                                <div class="form-group">
                                    <label for="reserve">Reserve</label>
                                    <input type="text" id="reserve" class="form-control"
                                        placeholder="Entrez une valeur pour reserve" name="reserve">
                                </div>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-12 d-flex justify-content-center">
                                <button type="submit" class="btn btn-sm btn-outline-primary me-3">
                                    <i class="fa-solid fa-check-to-slot"></i> Valider
                                </button>
                                <button type="reset" class="btn btn-sm btn-outline-primary">
                                    <i class="fa-solid fa-square-xmark"></i> Annuler
                                </button>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
