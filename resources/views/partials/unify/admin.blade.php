<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title"><u>Formulaire d'ajout des comptes</u></h4>
            </div>
            <div class="card-content">
                <div class="card-body">
                    @if (session('create'))
                    <script>
                        Swal.fire({
                            icon: 'success',
                            title: 'Ajout',
                            text: "{{ session('create') }}",
                            showConfirmButton: true
                        });
                    </script>
                    else@if (session('error'))
                    <script>
                        Swal.fire({
                            icon: 'danger',
                            title: 'Erreur',
                            text: "{{ session('error') }}",
                            showConfirmButton: true
                        });
                    </script>
                    @endif
                    <form action="{{route('ipaki.create')}}" method="post" id="userForm" class="form form-horizontal">
                        @csrf
                        <div class="form-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <label>Code</label>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group has-icon-left">
                                        <div class="position-relative">
                                            <input name="code" id="code" type="text" class="form-control"
                                                placeholder="Saisissez un code" required>
                                            <div class="form-control-icon">
                                                <i class="fa-solid fa-file-signature"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label>Label</label>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group has-icon-left">
                                        <div class="position-relative">
                                            <input name="label" id="label" type="text" class="form-control"
                                                placeholder="Saisissez un label" required>
                                            <div class="form-control-icon">
                                                <i class="fa-solid fa-file-signature"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label>Accounting ID</label>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group has-icon-left">
                                        <div class="position-relative">
                                            <input name="accounting_id" id="accounting_id" type="text"
                                                class="form-control" placeholder="Saisissez un accounting_id " required>
                                            <div class="form-control-icon">
                                                <i class="fa-solid fa-file-signature"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <br>
                                <div class="col-12 d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary me-1 mb-1">VALIDER</button>
                                    <button type="reset" class="btn btn-light-secondary me-1 mb-1">ANNULER</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12 col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title"><u>Liste des tiers</u></h4>
            </div>
            <div class="card-body">
                <form action="{{ route('ipaki.form') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input class="form-control form-control-md" id="formFileLg" type="file" name="file"
                        accept=".xlsx,.csv" required>
                    <br>
                    <button type="submit" name="submit" class="btn btn-primary" value="import"><i
                            class="fa-solid fa-upload"></i> IMPORTER</button>
                    <a href="{{ route('ipaki.export') }}" class="btn btn-danger"><i
                            class="fa-solid fa-download"></i> EXPORTER</a>

                </form>
                <br>
                <table class="table table-striped" id="table1">
                    <thead>
                        <tr>
                            <th>Code</th>
                            <th>Label</th>
                            <th>Accounting Id</th>
                            <th>Active</th>
                            <th>Billable</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tiers as $t)
                        <tr>
                            <td>{{ $t->code }}</td>
                            <td>{{ $t->label }}</td>
                            <td>{{ $t->accounting_id }}</td>
                            <td>{{ $t->active }}</td>
                            <td>{{ $t->billable }}</td>
                            <td>
                                <button type="button" class="btn btn-primary btn-edit" data-id="{{ $t->id }}"
                                    data-code="{{ $t->code }}" data-label="{{ $t->label }}"
                                    data-active="{{ $t->active }}" data-billable="{{ $t->billable }}"
                                    data-accounting_id="{{ $t->accounting_id }}" data-bs-toggle="modal"
                                    data-bs-target="#editModal"><i class="fa-solid fa-pen-to-square"></i></button>
                                <form method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-danger btn-delete" data-id="{{ $t->id }}"
                                        data-bs-toggle="modal" data-bs-target="#deleteModal"><i
                                            class="fa-solid fa-trash"></i></button>
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
                            <h5 class="modal-title" id="editModalLabel">Modifier le tiers</h5>
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
                                    <label for="editCode" class="form-label">Code</label>
                                    <input type="text" class="form-control" id="editCode" required name="code">
                                </div>
                                <div class="mb-3">
                                    <label for="editLabel" class="form-label">Label</label>
                                    <input type="text" class="form-control" id="editLabel" required name="label">
                                </div>
                                <div class="mb-3">
                                    <label for="editActive" class="form-label">Active</label>
                                    <input type="text" class="form-control" id="editActive" required name="active">
                                </div>
                                <div class="mb-3">
                                    <label for="editBillable" class="form-label">Billable</label>
                                    <input type="text" class="form-control" id="editBillable" required name="billable">
                                </div>
                                <div class="mb-3">
                                    <label for="editAccountingId" class="form-label">Accounting Id</label>
                                    <input type="text" class="form-control" id="editAccountingId" required
                                        name="accounting_id">
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Modifier</button>
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Fermer</button>
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
                            <h5 class="modal-title" id="deleteModalLabel">Supprimer le tiers</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>Êtes-vous sûr de vouloir supprimer ce tiers ?</p>
                            <form id="deleteForm" method="POST">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" id="deleteId" name="id">
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-danger">Supprimer</button>
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Annuler</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </section>
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
                    let code = this.getAttribute("data-code");
                    let label = this.getAttribute("data-label");
                    let active = this.getAttribute("data-active");
                    let billable = this.getAttribute("data-billable");
                    let accounting_id = this.getAttribute("data-accounting_id");

                    document.getElementById("editId").value = id;
                    document.getElementById("editCode").value = code;
                    document.getElementById("editLabel").value = label;
                    document.getElementById("editActive").value = active;
                    document.getElementById("editBillable").value = billable;
                    document.getElementById("editAccountingId").value = accounting_id;

                    document.getElementById("editForm").action = "/ipaki/update/" + id;
                });
            });

            document.querySelectorAll(".btn-delete").forEach(button => {
                button.addEventListener("click", function() {
                    let id = this.getAttribute("data-id");
                    document.getElementById("deleteId").value = id;
                    document.getElementById("deleteForm").action = "/ipaki/delete/" + id;
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

</div>