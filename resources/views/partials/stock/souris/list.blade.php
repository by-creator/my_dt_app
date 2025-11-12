 <div class="col-md-12 col-12">
     <div class="card">
         <div class="card-header">
             <h4 class="card-title"><u>Liste des souris</u></h4>
         </div>
         <div class="card-body">
             <form action="{{ route('souris.import') }}" method="post" enctype="multipart/form-data">
                 @csrf
                 <input class="form-control form-control-md" id="formFileLg" type="file" name="file" accept=".xlsx">
                 <br>
                 <button type="submit" class="btn btn-primary"><i class="fa-solid fa-upload"></i> Importer</button>
                 <a href="{{ route('souris.export') }}" class="btn btn-danger"><i class="fa-solid fa-download"></i> Exporter</a>
             </form>
             <br>
             <table class="table table-striped" id="table1">
                 <thead>
                     <tr>
                         <th>Date de réception</th>
                         <th>Date de déploiement</th>
                         <th>Marque</th>
                         <th>Utilisateur</th>
                     </tr>
                 </thead>
                 <tbody>
                     @foreach ($souriss as $souris)
                     <tr>
                         <td>{{ $souris->date_reception_formatted ?? '—'  }}</td>
                         <td>{{ $souris->date_deploiement_formatted ?? '—'  }}</td>
                         <td>{{ $souris->marque }}</td>
                         <td>{{ $souris->utilisateur }}</td>
                         <td>
                             <button type="button" class="btn btn-primary btn-edit"
                                 data-id="{{ $souris->id }}"
                                 data-date_reception="{{ $souris->date_reception}}"
                                 data-date_deploiement="{{ $souris->date_deploiement }}"
                                 data-marque="{{ $souris->marque }}"
                                 data-utilisateur="{{ $souris->utilisateur }}"
                                 data-bs-toggle="modal"
                                 data-bs-target="#editModal">
                                 <i class="fa-solid fa-pen-to-square"></i> Modifier
                             </button>
                         </td>
                         <td>
                             <button type="button" class="btn btn-danger btn-delete" data-id="{{ $souris->id }}" data-bs-toggle="modal" data-bs-target="#deleteModal"><i class="fa-solid fa-trash"></i> Supprimer</button>
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
                         <h5 class="modal-title" id="editModalLabel">Modifier ce souris</h5>
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
                                 <label for="editMarque" class="form-label">Marque</label>
                                 <input type="text" class="form-control" id="editMarque" name="marque">
                             </div>
                             <div class="mb-3">
                                 <label for="editUtilisateur" class="form-label">Utilisateur</label>
                                 <input type="text" class="form-control" id="editUtilisateur" name="utilisateur">
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
                         <h5 class="modal-title" id="deleteModalLabel">Supprimer cet souris</h5>
                         <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                     </div>
                     <div class="modal-body">
                         <p>Êtes-vous sûr de vouloir supprimer ce souris ?</p>
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
             document.getElementById("editMarque").value = btn.dataset.marque || '';
             document.getElementById("editUtilisateur").value = btn.dataset.utilisateur || '';
             document.getElementById("editForm").action = "/souris/update/" + id;
         });

         // Event delegation pour Delete
         table.addEventListener('click', function(e) {
             const btn = e.target.closest('.btn-delete');
             if (!btn) return;

             const id = btn.dataset.id;
             document.getElementById("deleteId").value = id;
             document.getElementById("deleteForm").action = "/souris/delete/" + id;
         });

         // Initialiser la datatable
         new simpleDatatables.DataTable("#table1");
     });
 </script>