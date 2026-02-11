<section id="multiple-column-form">
    <div class="row match-height">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title"><u>Formulaire d'ajout de téléphone mobile</u></h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <form action="{{ route('telephone-mobiles.import') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf

                            <div class="form-group">
                                <label>Importer des téléphones</label>

                                <div class="row">
                                    <div class="col-md-6 col-12">
                                        <input type="file" name="file" class="form-control"
                                            accept=".xlsx,.xls,.csv" required>
                                    </div>

                                    <div class="col-md-3 col-12 d-flex align-items-end">
                                        <button class="btn btn-sm btn-outline-primary w-100 me-2" type="submit">
                                            ⬆️ Importer
                                        </button>

                                        <a href="{{ route('telephone-mobiles.export') }}"
                                            class="btn btn-sm btn-outline-success w-100">
                                            ⬇️ Exporter
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </form>


                        <hr>

                        <form class="form" method="POST" action="{{ route('telephone-mobiles.store') }}">
                            @csrf

                            <div class="row">

                                {{-- Matricule --}}
                                <div class="col-md-2 col-12">
                                    <div class="form-group">
                                        <label>Matricule</label>
                                        <input type="text" class="form-control" name="matricule"
                                            placeholder="Ex : DT-4587">
                                    </div>
                                </div>

                                {{-- Nom --}}
                                <div class="col-md-2 col-12">
                                    <div class="form-group">
                                        <label>Nom</label>
                                        <input type="text" class="form-control" name="nom"
                                            placeholder="Ex : Diop">
                                    </div>
                                </div>

                                {{-- Prénom --}}
                                <div class="col-md-2 col-12">
                                    <div class="form-group">
                                        <label>Prénom</label>
                                        <input type="text" class="form-control" name="prenom"
                                            placeholder="Ex : Mamadou">
                                    </div>
                                </div>

                                {{-- Service --}}
                                <div class="col-md-2 col-12">
                                    <div class="form-group">
                                        <label>Service</label>
                                        <input type="text" class="form-control" name="service"
                                            placeholder="Ex : Informatique">
                                    </div>
                                </div>

                                {{-- Destination --}}
                                <div class="col-md-2 col-12">
                                    <div class="form-group">
                                        <label>Destination</label>
                                        <input type="text" class="form-control" name="destination"
                                            placeholder="Ex : Direction Générale">
                                    </div>
                                </div>

                                {{-- Modèle téléphone --}}
                                <div class="col-md-2 col-12">
                                    <div class="form-group">
                                        <label>Modèle téléphone</label>
                                        <input type="text" class="form-control" name="modele_telephone"
                                            placeholder="Ex : Samsung Galaxy A14">
                                    </div>
                                </div>

                                {{-- Référence téléphone --}}
                                <div class="col-md-2 col-12">
                                    <div class="form-group">
                                        <label>Référence téléphone</label>
                                        <input type="text" class="form-control" name="reference_telephone"
                                            placeholder="Ex : SM-A145F">
                                    </div>
                                </div>

                                {{-- Ancien forfait --}}
                                <div class="col-md-2 col-12">
                                    <div class="form-group">
                                        <label>Ancien forfait TTC</label>
                                        <input type="text" class="form-control" name="montant_ancien_forfait_ttc"
                                            placeholder="Ex : 12 000">
                                    </div>
                                </div>

                                {{-- Numéro SIM --}}
                                <div class="col-md-2 col-12">
                                    <div class="form-group">
                                        <label>Numéro SIM</label>
                                        <input type="text" class="form-control" name="numero_sim"
                                            placeholder="Ex : 770123456">
                                    </div>
                                </div>

                                {{-- Formule premium --}}
                                <div class="col-md-2 col-12">
                                    <div class="form-group">
                                        <label>Formule premium</label>
                                        <input type="text" class="form-control" name="formule_premium"
                                            placeholder="Ex : Oui / Non">
                                    </div>
                                </div>

                                {{-- Nouveau forfait --}}
                                <div class="col-md-2 col-12">
                                    <div class="form-group">
                                        <label>Forfait TTC</label>
                                        <input type="text" class="form-control" name="montant_forfait_ttc"
                                            placeholder="Ex : 18 000">
                                    </div>
                                </div>

                                {{-- Code PUK --}}
                                <div class="col-md-2 col-12">
                                    <div class="form-group">
                                        <label>Code PUK</label>
                                        <input type="text" class="form-control" name="code_puk"
                                            placeholder="Ex : 12345678">
                                    </div>
                                </div>

                                {{-- Date acquisition --}}
                                <div class="col-md-2 col-12">
                                    <div class="form-group">
                                        <label>Date acquisition</label>
                                        <input type="date" class="form-control" name="acquisition_date"
                                            placeholder="JJ/MM/AAAA">
                                    </div>
                                </div>

                                {{-- Statut --}}
                                <div class="col-md-2 col-12">
                                    <div class="form-group">
                                        <label>Statut</label>
                                        <input type="text" class="form-control" name="statut"
                                            placeholder="Ex : Actif / Suspendu / Résilié">
                                    </div>
                                </div>

                                {{-- Cause changement --}}
                                <div class="col-md-3 col-12">
                                    <div class="form-group">
                                        <label>Cause du changement</label>
                                        <input type="text" class="form-control" name="cause_changement"
                                            placeholder="Ex : Changement de service">
                                    </div>
                                </div>

                                {{-- IMSI --}}
                                <div class="col-md-3 col-12">
                                    <div class="form-group">
                                        <label>IMSI</label>
                                        <input type="text" class="form-control" name="imsi"
                                            placeholder="Ex : 608010123456789">
                                    </div>
                                </div>

                                {{-- Actions --}}
                                <div class="col-12 d-flex justify-content-end mt-2">
                                    <button type="submit" class="btn btn-sm btn-outline-success me-1">
                                        ✅ Valider
                                    </button>
                                    <button type="reset" class="btn btn-sm btn-outline-danger">
                                        🟥 Annuler
                                    </button>
                                </div>

                            </div>
                        </form>


                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
