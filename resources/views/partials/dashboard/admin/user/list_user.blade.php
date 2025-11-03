<section class="section">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title"><u>Liste des utilisateurs</u></h4>
        </div>
        <div class="card-body">
            <form action="{{ route('user.import') }}" method="post" enctype="multipart/form-data">
                @csrf
                <input class="form-control form-control-md" id="formFileLg" type="file" name="file" accept=".xlsx" required>
                <br>
                <button type="submit" class="btn btn-primary"><i class="fa-solid fa-upload"></i> Importer</button>
                <a href="{{ route('user.export') }}" class="btn btn-danger"><i class="fa-solid fa-download"></i> Exporter</a>
            </form>
            <br>
            <table class="table table-striped" id="table1">
                <thead>
                    <tr>
                        <th>Role</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                    <tr>
                        <td>
                            @php
                            $role = $roles->firstWhere('id', $user->role_id);
                            @endphp
                            {{ $role ? $role->name : 'Role non trouvé' }}
                        </td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            <button type="button" class="btn btn-primary btn-edit" data-id="{{ $user->id }}" data-role="{{ $user->role_id }}" data-name="{{ $user->name }}" data-username="{{ $user->username }}" data-email="{{ $user->email }}" data-password="{{ $user->password }}" data-bs-toggle="modal" data-bs-target="#editModal"><i class="fa-solid fa-pen-to-square"></i></button>

                            <button type="button" class="btn btn-danger btn-delete" data-id="{{ $user->id }}" data-bs-toggle="modal" data-bs-target="#deleteModal"><i class="fa-solid fa-trash"></i></button>
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
                        <h5 class="modal-title" id="editModalLabel">Modifier l'utilisateur</h5>
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
                                <label for="editRole" class="form-label">Rôle</label>
                                <select id="editRole" class="form-control" required name="role_id">
                                    <option value="">Choisissez un role</option>
                                    @foreach($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="editName" class="form-label">Nom</label>
                                <input type="text" class="form-control" id="editName" required name="name">
                            </div>
                            <div class="mb-3">
                                <label for="editEmail" class="form-label">Email</label>
                                <input type="email" class="form-control" id="editEmail" required name="email">
                            </div>
                            <div class="mb-3">
                                <label for="editPassword" class="form-label">Mot de passe</label>
                                <input type="password" class="form-control" id="editPassword" required name="password">
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
        <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLabel">Supprimer l'utilisateur</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Êtes-vous sûr de vouloir supprimer cet utilisateur ?</p>
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
                                <button type="submit" class="btn btn-danger">Supprimer</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
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
            let table1 = document.querySelector('#table1');

            function attachEventListeners() {
                document.querySelectorAll(".btn-edit").forEach(button => {
                    button.addEventListener("click", function() {
                        let id = this.getAttribute("data-id");
                        let role = this.getAttribute("data-role");
                        let name = this.getAttribute("data-name");
                        let email = this.getAttribute("data-email");
                        let username = this.getAttribute("data-username");
                        let password = this.getAttribute("data-password");

                        document.getElementById("editId").value = id;
                        document.getElementById("editRole").value = role;
                        document.getElementById("editName").value = name;
                        document.getElementById("editEmail").value = email;
                        document.getElementById("editPassword").value = password;

                        document.getElementById("editForm").action = "/user/update/" + id;
                    });
                });

                document.querySelectorAll(".btn-delete").forEach(button => {
                    button.addEventListener("click", function() {
                        let id = this.getAttribute("data-id");
                        document.getElementById("deleteId").value = id;
                        document.getElementById("deleteForm").action = "/user/delete/" + id;
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