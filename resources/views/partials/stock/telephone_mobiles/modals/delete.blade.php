         <!-- Modal Supprimer -->
         <div class="modal fade" id="deleteModal" tabindex="-1">
             <div class="modal-dialog">
                 <form id="deleteForm" method="POST">
                     @csrf
                     @method('DELETE')

                     <div class="modal-content">
                         <div class="modal-header">
                             <h5 class="modal-title">🗑️ Supprimer le téléphone mobile</h5>
                             <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                         </div>

                         <div class="modal-body">
                             <p>Voulez-vous vraiment supprimer ce téléphone ?</p>
                         </div>

                         <div class="modal-footer">
                             <button type="submit" class="btn btn-sm btn-outline-danger">Oui</button>
                             <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-dismiss="modal">Non</button>
                         </div>
                     </div>
                 </form>
             </div>
         </div>