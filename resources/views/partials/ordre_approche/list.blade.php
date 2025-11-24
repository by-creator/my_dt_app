 <div class="col-md-12 col-12">
     <div class="card">
         <div class="card-header">
             <h4 class="card-title"><u>Liste des vehicules</u></h4>
         </div>
         <div class="card-body">
             <table class="table table-striped" id="table1">
                 <thead>
                     <tr>
                         <th>Date</th>
                         <th>Numéro</th>
                         <th>Client</th>
                         <th>Type</th>
                     </tr>
                 </thead>
                 <tbody>
                     @foreach ($ordres as $ordre)
                     <tr>
                         <td>{{ $ordre->date}}</td>
                         <td>{{ $ordre->numero }}</td>
                         <td>{{ $ordre->client }}</td>
                         <td>{{ $ordre->type }}</td>
                         <td>
                             <button type="button" class="btn btn-primary btn-edit"
                                 data-id="{{ $ordre->id }}"
                                 data-date="{{ $ordre->date}}"
                                 data-numero="{{ $ordre->numero }}"
                                 data-client="{{ $ordre->client }}"
                                 data-type="{{ $ordre->type }}"
                                 data-bs-toggle="modal"
                                 data-bs-target="#editModal">
                                 <i class="fa-solid fa-pen-to-square"></i>
                                  Modifier
                             </button>
                         </td>
                         <td>
                             <button type="button" class="btn btn-danger btn-delete" data-id="{{ $ordre->id }}" data-bs-toggle="modal" data-bs-target="#deleteModal"><i class="fa-solid fa-trash"></i> Supprimer</button>
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
                         <h5 class="modal-title" id="editModalLabel">Modifier cet ordre</h5>
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
                                 <label for="editDate" class="form-label">Date</label>
                                 <input type="text" class="form-control" id="editDate" name="date">
                             </div>
                             <div class="mb-3">
                                 <label for="editNumero" class="form-label">Numéro</label>
                                 <input type="text" class="form-control" id="editNumero" name="numero">
                             </div>
                             <div class="mb-3">
                                 <label for="editClient" class="form-label">Client</label>
                                 <input type="text" class="form-control" id="editClient" name="client">
                             </div>
                             <div class="mb-3">
                                 <label for="editType" class="form-label">Type</label>
                                 <select class="form-control" name="type" id="editType" required>
                                     <option value="">Sélectionnez un type</option>
                                     <option value="VEHICULE">VEHICULE</option>
                                     <option value="CONTENEUR">CONTENEUR</option>
                                     <option value="GK">GK</option>
                                 </select>
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
                         <h5 class="modal-title" id="deleteModalLabel">Supprimer cet ordre</h5>
                         <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                     </div>
                     <div class="modal-body">
                         <p>Êtes-vous sûr de vouloir supprimer cet ordre ?</p>
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
             document.getElementById("editDate").value = btn.dataset.date || '';
             document.getElementById("editNumero").value = btn.dataset.numero || '';
             document.getElementById("editClient").value = btn.dataset.client || '';
             document.getElementById("editType").value = btn.dataset.type || '';
             document.getElementById("editForm").action = "/ordre-approche/update/" + id;
         });

         // Event delegation pour Delete
         table.addEventListener('click', function(e) {
             const btn = e.target.closest('.btn-delete');
             if (!btn) return;

             const id = btn.dataset.id;
             document.getElementById("deleteId").value = id;
             document.getElementById("deleteForm").action = "/ordre-approche/delete/" + id;
         });

         // Initialiser la datatable
         new simpleDatatables.DataTable("#table1");
     });
 </script>