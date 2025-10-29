 <div class="col-md-12 col-12">
     <div class="card">
         <div class="card-header">
             <h4 class="card-title"><u>Liste des ordinateurs</u></h4>
         </div>
         <div class="card-body">
             <form action="{{ route('ordinateur.import') }}" method="post" enctype="multipart/form-data">
                 @csrf
                 <input class="form-control form-control-md" id="formFileLg" type="file" name="file" accept=".xlsx" required>
                 <br>
                 <button type="submit" class="btn btn-primary"><i class="fa-solid fa-upload"></i>  IMPORTER</button>
                 <a href="{{ route('ordinateur.export') }}" class="btn btn-danger"><i class="fa-solid fa-download"></i>  EXPORTER</a>
             </form>
             <br>
             <table class="table table-striped" id="table1">
                 <thead>
                     <tr>
                         <th>Numéro de série</th>
                         <th>Modèle</th>
                         <th>Type</th>
                         <th>Utilisateur</th>
                         <th>Service</th>
                         <th>Site</th>
                         <th>Actions</th>
                     </tr>
                 </thead>
                 <tbody>
                     @foreach ($ordinateurs as $ordinateur)
                     <tr>
                         <td>{{ $ordinateur->serie }}</td>
                         <td>{{ $ordinateur->model }}</td>
                         <td>{{ $ordinateur->type }}</td>
                         <td>{{ $ordinateur->utilisateur }}</td>
                         <td>{{ $ordinateur->service }}</td>
                         <td>{{ $ordinateur->site }}</td>
                         <td>
                             <button type="button" class="btn btn-primary btn-edit"
                                 data-id="{{ $ordinateur->id }}"
                                 data-serie="{{ $ordinateur->serie }}"
                                 data-model="{{ $ordinateur->model }}"
                                 data-type="{{ $ordinateur->type }}"
                                 data-utilisateur="{{ $ordinateur->utilisateur }}"
                                 data-service="{{ $ordinateur->service }}"
                                 data-site="{{ $ordinateur->site }}"
                                 data-bs-toggle="modal"
                                 data-bs-target="#editModal">
                                 <i class="fa-solid fa-pen-to-square"></i>
                             </button>
                             <form method="POST" style="display:inline;">
                                 @csrf
                                 @method('DELETE')
                                 <button type="button" class="btn btn-danger btn-delete" data-id="{{ $ordinateur->id }}" data-bs-toggle="modal" data-bs-target="#deleteModal"><i class="fa-solid fa-trash"></i></button>
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
                         <h5 class="modal-title" id="editModalLabel">Modifier cet ordinateur</h5>
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
                                 <label for="editSerie" class="form-label">Numéro de série</label>
                                 <input type="text" class="form-control" id="editSerie" required name="serie">
                             </div>
                             <div class="mb-3">
                                 <label for="editModel" class="form-label">Modèle</label>
                                 <input type="text" class="form-control" id="editModel" required name="model">
                             </div>
                             <div class="mb-3">
                                 <label for="editType" class="form-label">Type</label>
                                 <input type="text" class="form-control" id="editType" required name="type">
                             </div>
                             <div class="mb-3">
                                 <label for="editUtilisateur" class="form-label">Utilisateur</label>
                                 <input type="text" class="form-control" id="editUtilisateur" required name="utilisateur">
                             </div>
                             <div class="mb-3">
                                 <label for="editService" class="form-label">Service</label>
                                 <input type="text" class="form-control" id="editService" required name="service">
                             </div>
                             <div class="mb-3">
                                 <label for="editSite" class="form-label">Site</label>
                                 <input type="text" class="form-control" id="editSite" required name="site">
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
                         <h5 class="modal-title" id="deleteModalLabel">Supprimer cet ordinateur</h5>
                         <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                     </div>
                     <div class="modal-body">
                         <p>Êtes-vous sûr de vouloir supprimer cet ordinateur ?</p>
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
                        let serie = this.getAttribute("data-serie");
                        let model = this.getAttribute("data-model");
                        let type = this.getAttribute("data-type");
                        let utilisateur = this.getAttribute("data-utilisateur");
                        let service = this.getAttribute("data-service");
                        let site = this.getAttribute("data-site");


                        document.getElementById("editId").value = id;
                        document.getElementById("editSerie").value = serie;
                        document.getElementById("editModel").value = model;
                        document.getElementById("editType").value = type;
                        document.getElementById("editUtilisateur").value = utilisateur;
                        document.getElementById("editService").value = service;
                        document.getElementById("editSite").value = site;


                        document.getElementById("editForm").action = "/ordinateur/update/" + id;
                    });
                });

                document.querySelectorAll(".btn-delete").forEach(button => {
                    button.addEventListener("click", function() {
                        let id = this.getAttribute("data-id");
                        document.getElementById("deleteId").value = id;
                        document.getElementById("deleteForm").action = "/ordinateur/delete/" + id;
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