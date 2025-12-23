<div>
    <div class="card">
        <div class="card-header">
            <h4 class="card-title"><u>Formulaire ordre approche</u></h4>
        </div>
        <div class="card-content">
            <div class="card-body">
                <form method="POST" action="{{ route('powerbi.fetch') }}">
                    @csrf
                    <div class="row">
                        <div class="col-md-3 col-12">
                            <div class="form-group">
                                <label for="date">Item number</label>
                                <div class="d-flex gap-2">
                                    <input type="text" name="item_number" class="form-control"
                                        placeholder="Entrez une valeur pour item">

                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa-solid fa-check-to-slot"></i>
                                    </button>

                                    <button type="reset" class="btn btn-danger">
                                        <i class="fa-solid fa-square-xmark"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <br>
                <form action="{{ route('ordre_approche.create') }}" method="post" target="_blank"
                    class="form form-horizontal">
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
                                    <label for="chassis">Chassis</label>
                                    <input type="text" id="chassis" class="form-control"
                                        placeholder="Entrez une valeur pour chassis" required name="chassis">
                                </div>
                            </div>
                            <div class="col-md-3 col-12">
                                <div class="form-group">
                                    <label for="zone">Zone</label>
                                    <input type="text" id="zone" class="form-control"
                                        placeholder="Entrez une valeur pour zone" required name="zone"
                                        value="{{ $zone ?? '' }}">
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
