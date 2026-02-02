 <div class="col-md-12 col-12">
     <div class="card">
         <div class="card-header">
             <h4 class="card-title"><u>Liste des items</u></h4>
         </div>
         <div class="card-body">
             <div class="table-responsive">
                 <form method="GET" action="{{ route('douane.index') }}" class="row g-2 mb-3">
                     <div class="col-md-3">
                         <label class="form-label small">Item Number</label>
                         <input list="ordres_list" name="ItemNumber" class="form-control"
                             placeholder="Saisir ou choisir un item" required value="{{ request('ItemNumber') }}">

                         <datalist id="ordres_list">
                             @foreach ($ordres as $ordre)
                                 <option value="{{ $ordre->ItemNumber }}">
                             @endforeach
                         </datalist>
                     </div>

                     <div class="col-md-3 d-flex align-items-end">
                         <button type="submit" class="btn btn-sm btn-outline-primary me-2">
                             🔍 Filtrer
                         </button>
                         <a href="{{ route('douane.index') }}" class="btn btn-sm btn-outline-primary me-2">
                             ♻️ Actualiser
                         </a>
                     </div>
                 </form>
                 <table class="table table-striped">
                     <thead>
                         <tr>
                             <th>Item Number</th>
                             <th>BL Number</th>
                             <th>Type</th>
                             <th>Description</th>
                         </tr>
                     </thead>
                     <tbody>
                         @foreach ($ordres as $ordre)
                             <tr>
                                 <td>{{ $ordre->ItemNumber }}</td>
                                 <td>{{ $ordre->BlNumber }}</td>
                                 <td>{{ $ordre->Item_Type }}</td>
                                 <td>{{ $ordre->Description_ }}</td>
                                 <td>
                                     <button type="button" class="btn btn-primary btn-edit"
                                         data-id="{{ $ordre->id }}"
                                         data-date_reception="{{ $ordre->date_reception }}"
                                         data-date_deploiement="{{ $ordre->date_deploiement }}"
                                         data-marque="{{ $ordre->marque }}"
                                         data-utilisateur="{{ $ordre->utilisateur }}" data-bs-toggle="modal"
                                         data-bs-target="#editModal">
                                         <i class="fa-solid fa-pen-to-square"></i> Modifier
                                     </button>
                                 </td>
                                 <td>
                                     <button type="button" class="btn btn-danger btn-delete"
                                         data-id="{{ $ordre->id }}" data-bs-toggle="modal"
                                         data-bs-target="#deleteModal"><i class="fa-solid fa-trash"></i>
                                         Supprimer</button>
                                 </td>
                             </tr>
                         @endforeach
                     </tbody>
                 </table>
             </div>
             <div class="d-flex justify-content-between align-items-center mt-3">
                 <div class="small text-muted">
                     Affichage de {{ $ordres->firstItem() }} à {{ $ordres->lastItem() }}
                     sur {{ $ordres->total() }} résultats
                 </div>

                 <div>
                     {{ $ordres->links() }}
                 </div>
             </div>
         </div>

         <!-- Modal Modifier -->
         <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
             <div class="modal-dialog">
                 <div class="modal-content">
                     <div class="modal-header">
                         <h5 class="modal-title" id="editModalLabel">Modifier ce clavier</h5>
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
                                 <input type="datetime-local" class="form-control" id="editDateReception"
                                     name="date_reception">
                             </div>
                             <div class="mb-3">
                                 <label for="editDateDeploiement" class="form-label">Date de déploiement</label>
                                 <input type="datetime-local" class="form-control" id="editDateDeploiement"
                                     name="date_deploiement">
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
                                 <button type="submit" class="btn btn-primary"><i
                                         class="fa-solid fa-check-to-slot"></i> Modifier</button>
                                 <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><i
                                         class="fa-solid fa-square-xmark"></i> Fermer</button>
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
         <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel"
             aria-hidden="true">
             <div class="modal-dialog">
                 <div class="modal-content">
                     <div class="modal-header">
                         <h5 class="modal-title" id="deleteModalLabel">Supprimer cet clavier</h5>
                         <button type="button" class="btn-close" data-bs-dismiss="modal"
                             aria-label="Close"></button>
                     </div>
                     <div class="modal-body">
                         <p>Êtes-vous sûr de vouloir supprimer ce clavier ?</p>
                         <form id="deleteForm" method="POST">
                             @csrf
                             @method('DELETE')
                             <input type="hidden" id="deleteId" name="id">
                             <div class="modal-footer">
                                 <button type="submit" class="btn btn-primary"><i
                                         class="fa-solid fa-check-to-slot"></i> Oui</button>
                                 <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><i
                                         class="fa-solid fa-square-xmark"></i> Non</button>
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
             document.getElementById("editForm").action = "/clavier/update/" + id;
         });

         // Event delegation pour Delete
         table.addEventListener('click', function(e) {
             const btn = e.target.closest('.btn-delete');
             if (!btn) return;

             const id = btn.dataset.id;
             document.getElementById("deleteId").value = id;
             document.getElementById("deleteForm").action = "/clavier/delete/" + id;
         });

         // Initialiser la datatable
         new simpleDatatables.DataTable("#table1");
     });
 </script>
