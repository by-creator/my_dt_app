<div class="col-md-12 col-12">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title"><u>Liste des postes</u></h4>
        </div>
        <div class="card-body">
            <form action="{{ route('telephone-fixe.import') }}" method="post" enctype="multipart/form-data">
                @csrf
                <input class="form-control form-control-md" id="formFileLg" type="file" name="file" accept=".xlsx" required>
                <br>
                <button type="submit" class="btn btn-primary"><i class="fa-solid fa-upload"></i>  IMPORTER</button>
                <a href="{{ route('telephone-fixe.export') }}" class="btn btn-danger"><i class="fa-solid fa-download"></i>  EXPORTER</a>
            </form>
            <br>
            <table class="table table-striped" id="table1">
                <thead>
                    <tr>
                        <th>Annuaire</th>
                        <th>Nom</th>
                        <th>Prenom</th>
                        <th>Type</th>
                        <th>Entite</th>
                        <th>Role</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($fixes as $fixe)
                    <tr>
                        <td>{{ $fixe->annuaire }}</td>
                        <td>{{ $fixe->nom }}</td>
                        <td>{{ $fixe->prenom }}</td>
                        <td>{{ $fixe->type }}</td>
                        <td>{{ $fixe->entite }}</td>
                        <td>{{ $fixe->role }}</td>
                        <td>
                            <button type="button" class="btn btn-primary btn-edit" data-id="{{ $fixe->id }}" data-annuaire="{{ $fixe->annuaire }}" data-nom="{{ $fixe->nom }}" data-prenom="{{ $fixe->prenom }}" data-type="{{ $fixe->type }}" data-entite="{{ $fixe->entite }}" data-role="{{ $fixe->role }}" data-bs-toggle="modal" data-bs-target="#editModal"><i class="fa-solid fa-pen-to-square"></i></button>
                            <form method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-danger btn-delete" data-id="{{ $fixe->id }}" data-bs-toggle="modal" data-bs-target="#deleteModal"><i class="fa-solid fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- Modal Modifier -->
        <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Modifier le poste</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
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
                        <form id="editForm" method="POST">
                            @csrf
                            @method('PUT')
                            <input type="hidden" id="editId" name="id">
                            <div class="mb-3">
                                <label for="editAnnuaire" class="form-label">Annuaire</label>
                                <input type="text" class="form-control" id="editAnnuaire" required name="annuaire">
                            </div>
                            <div class="mb-3">
                                <label for="editNom" class="form-label">Nom</label>
                                <input type="text" class="form-control" id="editNom" required name="nom">
                            </div>
                            <div class="mb-3">
                                <label for="editPrenom" class="form-label">Prenom</label>
                                <input type="text" class="form-control" id="editPrenom" required name="prenom">
                            </div>
                            <div class="mb-3">
                                <label for="editType" class="form-label">Type</label>
                                <input type="text" class="form-control" id="editType" required name="type">
                            </div>
                            <div class="mb-3">
                                <label for="editEntite" class="form-label">Entite</label>
                                <input type="text" class="form-control" id="editEntite" required name="entite">
                            </div>
                            <div class="mb-3">
                                <label for="editRole" class="form-label">Role</label>
                                <input type="text" class="form-control" id="editRole" required name="role">
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Modifier</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal Supprimer -->
        @if (session('delete'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Suppression',
                text: "{{ session('delete') }}",
                showConfirmButton: true
            });
        </script>
        @endif
        <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLabel">Supprimer le poste</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Êtes-vous sûr de vouloir supprimer ce poste ?</p>
                        <form id="deleteForm" method="POST">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" id="deleteId" name="id">
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-danger">Supprimer</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
        document.addEventListener("DOMContentLoaded", function() {
            let table1 = document.querySelector('#table1');

            function attachEventListeners() {
                document.querySelectorAll(".btn-edit").forEach(button => {
                    button.addEventListener("click", function() {
                        let id = this.getAttribute("data-id");
                        let annuaire = this.getAttribute("data-annuaire");
                        let nom = this.getAttribute("data-nom");
                        let prenom = this.getAttribute("data-prenom");
                        let type = this.getAttribute("data-type");
                        let entite = this.getAttribute("data-entite");
                        let role = this.getAttribute("data-role");

                        document.getElementById("editId").value = id;
                        document.getElementById("editAnnuaire").value = annuaire;
                        document.getElementById("editNom").value = nom;
                        document.getElementById("editPrenom").value = prenom;
                        document.getElementById("editType").value = type;
                        document.getElementById("editEntite").value = entite;
                        document.getElementById("editRole").value = role;

                        document.getElementById("editForm").action = "/telephone-fixe/update/" + id;
                    });
                });

                document.querySelectorAll(".btn-delete").forEach(button => {
                    button.addEventListener("click", function() {
                        let id = this.getAttribute("data-id");
                        document.getElementById("deleteId").value = id;
                        document.getElementById("deleteForm").action = "/telephone-fixe/delete/" + id;
                    });
                });
            }

            // Attacher les événements initiaux
            attachEventListeners();

            // Réattacher les événements après chaque changement de page ou rechargement du tableau
            let dataTable = new simpleDatatables.DataTable("#table1");
            dataTable.on('datatable.init', attachEventListeners);
            dataTable.on('datatable.page', attachEventListeners);
            dataTable.on('datatable.search', attachEventListeners);
        });
    </script>