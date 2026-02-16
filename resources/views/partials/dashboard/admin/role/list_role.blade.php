<section class="section">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title"><u>Liste des rôles</u></h4>
        </div>
        <div class="card-body">
            <table class="table table-striped" id="table1">
                <thead>
                    <tr>
                        <th>Nom</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($roles as $role)
                    <tr>
                        <td>{{ $role->name }}</td>
                        <td>
                            <button type="button" class="btn btn-sm btn-outline-primary" data-id="{{ $role->id }}" data-name="{{ $role->name }}" data-bs-toggle="modal" data-bs-target="#editModal"><i class="fa-solid fa-pen-to-square"></i> Modifier</button>
                        </td> 
                        <td>
                            <button type="button" class="btn btn-sm btn-outline-primary" data-id="{{ $role->id }}" data-bs-toggle="modal" data-bs-target="#deleteModal"><i class="fa-solid fa-trash"></i> Supprimer</button>
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
                        <h5 class="modal-title" id="editModalLabel">Modifier le rôle</h5>
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
                                <label for="editName" class="form-label">Nom</label>
                                <input type="text" class="form-control" name="name" id="editName" required>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-sm btn-outline-primary"><i class="fa-solid fa-pen-to-square"></i> Modifier</button>
                                <button type="button" class="btn btn-sm btn-outline-primary" data-bs-dismiss="modal"><i class="fa-solid fa-square-xmark"></i> Annuler</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal Supprimer -->
        <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLabel">Supprimer le rôle</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Êtes-vous sûr de vouloir supprimer ce rôle ?</p>
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
                        <form id="deleteForm" method="POST">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" id="deleteId" name="id">
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-sm btn-outline-primary"><i class="fa-solid fa-pen-to-square"></i> Oui</button>
                                <button type="button" class="btn btn-sm btn-outline-primary" data-bs-dismiss="modal"><i class="fa-solid fa-square-xmark"></i> Non</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const table = document.getElementById('table1');

        // Event delegation pour Edit
        table.addEventListener('click', function(e) {
            const btn = e.target.closest('.btn-edit');
            if (!btn) return; // Si ce n'est pas un bouton edit, on ignore

            const id = btn.dataset.id;
            document.getElementById("editId").value = id;
            document.getElementById("editName").value = btn.dataset.name || '';
            document.getElementById("editForm").action = "/role/update/" + id;
        });

        // Event delegation pour Delete
        table.addEventListener('click', function(e) {
            const btn = e.target.closest('.btn-delete');
            if (!btn) return;

            const id = btn.dataset.id;
            document.getElementById("deleteId").value = id;
            document.getElementById("deleteForm").action = "/role/delete/" + id;
        });

        // Initialiser la datatable
        new simpleDatatables.DataTable("#table1");
    });
</script>