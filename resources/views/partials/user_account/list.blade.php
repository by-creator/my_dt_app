<section class="section">
    <div class="card">
        <div class="card-header">
            <h4><u>Liste des comptes</u></h4>
        </div>
        <div class="card-body">
            <form action="{{ route('user_accounts.import') }}" method="post" enctype="multipart/form-data">
                @csrf
                <input class="form-control form-control-md" id="formFileLg" type="file" name="file" accept=".xlsx" required>
                <br>
                <button type="submit" class="btn btn-primary"><i class="fa-solid fa-upload"></i> Importer</button>
                <a href="{{ route('user_accounts.export') }}" class="btn btn-danger"><i class="fa-solid fa-download"></i> Exporter</a>
            </form>
            <br>
            <table class="table table-striped" id="table1">
                <thead>
                    <tr>
                        <th>Date de Début</th>
                        <th>Date de Fin</th>
                        <th>Nom & Prénom(s)</th>
                        <th>Département</th>
                        <th>Email</th>
                        <th>Job Title</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($user_accounts as $user_account)
                    <tr>
                        <td>{{ $user_account->created_time_formatted ?? '—' }}</td>
                        <td>{{ $user_account->employee_end_date_formatted ?? '—' }}</td>
                        <td>{{ $user_account->display_name }}</td>
                        <td>{{ $user_account->department }}</td>
                        <td>{{ $user_account->email }}</td>
                        <td>{{ $user_account->job_title }}</td>
                        <td>
                            <button type="button" class="btn btn-primary btn-edit" data-id="{{ $user_account->id }}" data-name="{{ $user_account->name }}" data-bs-toggle="modal" data-bs-target="#editModal"><i class="fa-solid fa-pen-to-square"></i></button>
                        </td>
                        <td>
                            <button type="button" class="btn btn-danger btn-delete" data-id="{{ $user_account->id }}" data-bs-toggle="modal" data-bs-target="#deleteModal"><i class="fa-solid fa-trash"></i></button>
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
                                <button type="submit" class="btn btn-primary">Modifier</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
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
                    let name = this.getAttribute("data-name");


                    document.getElementById("editId").value = id;
                    document.getElementById("editName").value = name;

                    document.getElementById("editForm").action = "/user_account/update/" + id;
                });
            });

            document.querySelectorAll(".btn-delete").forEach(button => {
                button.addEventListener("click", function() {
                    let id = this.getAttribute("data-id");
                    document.getElementById("deleteId").value = id;
                    document.getElementById("deleteForm").action = "/user_account/delete/" + id;
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