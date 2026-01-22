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
                            <div class="col-md-3 col-12">
                                <div class="form-group">
                                    <label for="ItemNumber">ItemNumber</label>
                                    <input type="text" id="ItemNumber" class="form-control"
                                        placeholder="Entrez une valeur pour ItemNumber" required name="ItemNumber"
                                        value="{{ $ordre->item_number ?? '' }}">
                                </div>
                            </div>
                            <div class="col-md-3 col-12">
                                <div class="form-group">
                                    <label for="zone">Zone</label>
                                    <input type="text" id="zone" class="form-control"
                                        placeholder="Entrez une valeur pour zone" required name="Zone"
                                        value="{{ $ordre->zone ?? '' }}">
                                </div>
                            </div>
                            <div class="col-md-3 col-12">
                                <div class="form-group">
                                    <label for="TypeDeMarchandise">Type De Marchandise</label>
                                    <input type="text" id="TypeDeMarchandise" class="form-control"
                                        placeholder="Entrez une valeur pour TypeDeMarchandise" required name="TypeDeMarchandise"
                                        value="{{ $ordre->type_de_marchandise ?? '' }}">
                                </div>
                            </div>
                            <div class="col-md-3 col-12">
                                <div class="form-group">
                                    <label for="BlNumber">BlNumber</label>
                                    <input type="text" id="BlNumber" class="form-control" required
                                        placeholder="Entrez une valeur pour BL" name="BlNumber"
                                        value="{{ $ordre->bl_number ?? '' }}">
                                </div>
                            </div>
                            <div class="col-md-3 col-12">
                                <div class="form-group">
                                    <label for="Vessel">Vessel</label>
                                    <input type="text" id="Vessel" class="form-control" required
                                        placeholder="Entrez une valeur pour Vessel" name="Vessel"
                                        value="{{ $ordre->vessel ?? '' }}">
                                </div>
                            </div>
                            <div class="col-md-3 col-12">
                                <div class="form-group">
                                    <label for="callNumber">callNumber</label>
                                    <input type="text" id="callNumber" class="form-control" required
                                        placeholder="Entrez une valeur pour call number" name="callNumber"
                                        value="{{ $ordre->call_number ?? '' }}">
                                </div>
                            </div>
                            <div class="col-md-3 col-12">
                                <div class="form-group">
                                    <label for="vesselarrivaldate">Vessel Arrival Date</label>
                                    <input type="text" id="vesselarrivaldate" class="form-control" required
                                        placeholder="Entrez une valeur pour vessel arrival date" name="vesselarrivaldate"
                                        value="{{ $ordre->vessel_arrival_date ?? '' }}">
                                </div>
                            </div>
                            <div class="col-md-3 col-12">
                                <div class="form-group">
                                    <label for="Shipowner">Shipowner</label>
                                    <input type="text" id="Shipowner" class="form-control"
                                        placeholder="Entrez une valeur pour shipping line" required name="Shipowner"
                                        value="{{ $ordre->shipowner ?? '' }}">
                                </div>
                            </div>
                            <div class="col-md-3 col-12">
                                <div class="form-group">
                                    <label for="Item_Code">Item_Code</label>
                                    <input type="text" id="Item_Code" class="form-control"
                                        placeholder="Entrez une valeur pour Item_Code" required name="Item_Code"
                                        value="{{ $ordre->item_code ?? '' }}">
                                </div>
                            </div>
                            <div class="col-md-3 col-12">
                                <div class="form-group">
                                    <label for="Item_Type">Item_Type</label>
                                    <input type="text" id="Item_Type" class="form-control"
                                        placeholder="Entrez une valeur pour Item_Type" required name="Item_Type"
                                        value="{{ $ordre->item_type ?? '' }}">
                                </div>
                            </div>
                            <div class="col-md-3 col-12">
                                <div class="form-group">
                                    <label for="Description_">Description_</label>
                                    <input type="text" id="Description_" class="form-control"
                                        placeholder="Entrez une valeur pour Description_" required name="Description_"
                                        value="{{ $ordre->description ?? '' }}">
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                           <div class="col-md-3 col-12">
                                <div class="form-group">
                                    <label for="bae">BAE DOUANE</label>
                                    <input type="text" id="bae" class="form-control"
                                        placeholder="Entrez une valeur pour bae" name="bae">
                                </div>
                            </div>
                            <div class="col-md-3 col-12">
                                <div class="form-group">
                                    <label for="client">Client Facturé</label>
                                    <input type="text" id="client" class="form-control"
                                        placeholder="Entrez une valeur pour client" name="client">
                                </div>
                            </div>
                            <div class="col-md-3 col-12">
                                <div class="form-group">
                                    <label for="chauffeur">Nom Chauffeur</label>
                                    <input type="text" id="chauffeur" class="form-control"
                                        placeholder="Entrez une valeur pour chauffeur" name="chauffeur">
                                </div>
                            </div>
                            <div class="col-md-3 col-12">
                                <div class="form-group">
                                    <label for="permis">N° Permis</label>
                                    <input type="text" id="permis" class="form-control"
                                        placeholder="Entrez une valeur pour permis" name="permis">
                                </div>
                            </div>
                            <div class="col-md-3 col-12">
                                <div class="form-group">
                                    <label for="pointeur">Nom Pointeur Livreur</label>
                                    <input type="text" id="pointeur" class="form-control"
                                        placeholder="Entrez une valeur pour pointeur" name="pointeur">
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
                                    <label for="reserve">Reserve</label>
                                    <input type="text" id="reserve" class="form-control"
                                        placeholder="Entrez une valeur pour reserve" name="reserve">
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
