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
                            <button type="button" class="btn btn-primary btn-edit"
                                data-id="{{ $user_account->id }}" data-created-time="{{ $user_account->created_time }}" data-employee-end-date="{{ $user_account->employee_end_date }}"
                                data-display-name="{{ $user_account->display_name }}" data-department="{{ $user_account->department }}" data-email="{{ $user_account->email }}"
                                data-job-title="{{ $user_account->job_title }}"
                                data-bs-toggle="modal" data-bs-target="#editModal"><i class="fa-solid fa-pen-to-square"></i> Modifier</button>
                        </td>
                        <td>
                            <button type="button" class="btn btn-danger btn-delete" data-id="{{ $user_account->id }}" data-bs-toggle="modal" data-bs-target="#deleteModal"><i class="fa-solid fa-trash"></i> Supprimer</button>
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
                        <h5 class="modal-title" id="editModalLabel">Modifier le compte</h5>
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
                                <label for="editCreatedTime" class="form-label">Date début</label>
                                <input type="datetime-local" class="form-control" name="created_time" id="editCreatedTime" required>
                            </div>

                            <div class="mb-3">
                                <label for="editEmployeeEndDate" class="form-label">Date fin</label>
                                <input type="datetime-local" class="form-control" name="employee_end_date" id="editEmployeeEndDate" required>
                            </div>

                            <div class="mb-3">
                                <label for="editDisplayName" class="form-label">Nom & prénom(s)</label>
                                <input type="text" class="form-control" name="display_name" id="editDisplayName" required>
                            </div>

                            <div class="mb-3">
                                <label for="editDepartment" class="form-label">Département</label>
                                <input type="text" class="form-control" name="department" id="editDepartment" required>
                            </div>
                            <div class="mb-3">
                                <label for="editEmail" class="form-label">Email</label>
                                <input type="text" class="form-control" name="email" id="editEmail" required>
                            </div>
                            <div class="mb-3">
                                <label for="editJobTitle" class="form-label">Job Tilte</label>
                                <input type="text" class="form-control" name="job_title" id="editJobTitle" required>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary"><i class="fa-solid fa-check-to-slot"></i> Modifier</button>
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><i class="fa-solid fa-square-xmark"></i> Annuler</button>
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
                        <h5 class="modal-title" id="deleteModalLabel">Supprimer le compte</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Êtes-vous sûr de vouloir supprimer ce compte ?</p>
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
                                <button type="submit" class="btn btn-primary"><i class="fa-solid fa-check-to-slot"></i> Oui</button>
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><i class="fa-solid fa-square-xmark"></i> Non</button>
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
        document.getElementById("editCreatedTime").value = btn.dataset.createdTime || '';
        document.getElementById("editEmployeeEndDate").value = btn.dataset.employeeEndDate || '';
        document.getElementById("editDisplayName").value = btn.dataset.displayName || '';
        document.getElementById("editDepartment").value = btn.dataset.department || '';
        document.getElementById("editEmail").value = btn.dataset.email || '';
        document.getElementById("editJobTitle").value = btn.dataset.jobTitle || '';
        document.getElementById("editForm").action = "/user_accounts/update/" + id;
    });

    // Event delegation pour Delete
    table.addEventListener('click', function(e) {
        const btn = e.target.closest('.btn-delete');
        if (!btn) return;

        const id = btn.dataset.id;
        document.getElementById("deleteId").value = id;
        document.getElementById("deleteForm").action = "/user_accounts/delete/" + id;
    });

    // Initialiser la datatable
    new simpleDatatables.DataTable("#table1");
});
</script>

