 <div class="col-md-12 col-12">
     <div class="card">
         <div class="card-header">
             <h4 class="card-title"><u>Liste des ordinateurs</u></h4>
         </div>
         <div class="card-body">
             <form action="{{ route('ordinateur.import') }}" method="post" enctype="multipart/form-data">
                 @csrf
                 <input class="form-control form-control-md" id="formFileLg" type="file" name="file" accept=".xlsx">
                 <br>
                 <button type="submit" class="btn btn-primary"><i class="fa-solid fa-upload"></i> Importer</button>
                 <a href="{{ route('ordinateur.export') }}" class="btn btn-danger"><i class="fa-solid fa-download"></i> Exporter</a>
             </form>
             <br>
             <table class="table table-striped" id="table1">
                 <thead>
                     <tr>
                         <th>Date de réception</th>
                         <th>Date de déploiement</th>
                         <th>Numéro de série</th>
                         <th>Modèle</th>
                         <th>Type</th>
                         <th>Utilisateur</th>
                         <th>Service</th>
                         <th>Site</th>
                     </tr>
                 </thead>
                 <tbody>
                     @foreach ($ordinateurs as $ordinateur)
                     <tr>
                         <td>{{ $ordinateur->date_reception_formatted ?? '—'  }}</td>
                         <td>{{ $ordinateur->date_deploiement_formatted ?? '—'  }}</td>
                         <td>{{ $ordinateur->serie }}</td>
                         <td>{{ $ordinateur->model }}</td>
                         <td>{{ $ordinateur->type }}</td>
                         <td>{{ $ordinateur->utilisateur }}</td>
                         <td>{{ $ordinateur->service }}</td>
                         <td>{{ $ordinateur->site }}</td>
                         <td>
                             <button type="button" class="btn btn-primary btn-edit"
                                 data-id="{{ $ordinateur->id }}"
                                 data-date_reception="{{ $ordinateur->date_reception}}"
                                 data-date_deploiement="{{ $ordinateur->date_deploiement }}"
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
                         </td>
                         <td>
                             <button type="button" class="btn btn-danger btn-delete" data-id="{{ $ordinateur->id }}" data-bs-toggle="modal" data-bs-target="#deleteModal"><i class="fa-solid fa-trash"></i> </button>
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
                                 <label for="editDateReception" class="form-label">Date de réception</label>
                                 <input type="datetime-local" class="form-control" id="editDateReception" name="date_reception">
                             </div>
                             <div class="mb-3">
                                 <label for="editDateDeploiement" class="form-label">Date de déploiement</label>
                                 <input type="datetime-local" class="form-control" id="editDateDeploiement" name="date_deploiement">
                             </div>
                             <div class="mb-3">
                                 <label for="editSerie" class="form-label">Numéro de série</label>
                                 <input type="text" class="form-control" id="editSerie" name="serie">
                             </div>
                             <div class="mb-3">
                                 <label for="editModel" class="form-label">Modèle</label>
                                 <input type="text" class="form-control" id="editModel" name="model">
                             </div>
                             <div class="mb-3">
                                 <label for="editType" class="form-label">Type</label>
                                 <input type="text" class="form-control" id="editType" name="type">
                             </div>
                             <div class="mb-3">
                                 <label for="editUtilisateur" class="form-label">Utilisateur</label>
                                 <input type="text" class="form-control" id="editUtilisateur" name="utilisateur">
                             </div>
                             <div class="mb-3">
                                 <label for="editService" class="form-label">Service</label>
                                 <input type="text" class="form-control" id="editService" name="service">
                             </div>
                             <div class="mb-3">
                                 <label for="editSite" class="form-label">Site</label>
                                 <input type="text" class="form-control" id="editSite" name="site">
                             </div>
                             <div class="modal-footer">
                                 <button type="submit" class="btn btn-primary"><i class="fa-solid fa-check-to-slot"></i> Modifier</button>
                                 <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><i class="fa-solid fa-square-xmark"></i> Fermer</button>
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
                                 <button type="submit" class="btn btn-primary"><i class="fa-solid fa-check-to-slot"></i> Oui</button>
                                 <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><i class="fa-solid fa-square-xmark"></i> Non</button>
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
         const table = document.getElementById('table1');

         // Event delegation pour Edit
         table.addEventListener('click', function(e) {
             const btn = e.target.closest('.btn-edit');
             if (!btn) return; // Si ce n'est pas un bouton edit, on ignore

             const id = btn.dataset.id;
             document.getElementById("editId").value = id;
             document.getElementById("editDateReception").value = btn.dataset.date_reception || '';
             document.getElementById("editDateDeploiement").value = btn.dataset.date_deploiement || '';
             document.getElementById("editSerie").value = btn.dataset.serie || '';
             document.getElementById("editModel").value = btn.dataset.model || '';
             document.getElementById("editType").value = btn.dataset.type || '';
             document.getElementById("editUtilisateur").value = btn.dataset.utilisateur || '';
             document.getElementById("editService").value = btn.dataset.service || '';
             document.getElementById("editSite").value = btn.dataset.site || '';
             document.getElementById("editForm").action = "/ordinateur/update/" + id;
         });

         // Event delegation pour Delete
         table.addEventListener('click', function(e) {
             const btn = e.target.closest('.btn-delete');
             if (!btn) return;

             const id = btn.dataset.id;
             document.getElementById("deleteId").value = id;
             document.getElementById("deleteForm").action = "/ordinateur/delete/" + id;
         });

         // Initialiser la datatable
         new simpleDatatables.DataTable("#table1");
     });
 </script>