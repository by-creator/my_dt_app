<section class="section">
    <div class="card">
        <div class="card-header">
            <h4><u>Liste des machines</u></h4>
        </div>
        <div class="card-body">
            <form action="{{ route('machines.import') }}" method="post" enctype="multipart/form-data">
                @csrf
                <input class="form-control form-control-md" id="formFileMachine" type="file" name="file" accept=".xlsx,.csv">
                <br>
                <button type="submit" class="btn btn-primary"><i class="fa-solid fa-upload"></i> Importer</button>
                <a href="{{ route('machines.export') }}" class="btn btn-danger"><i class="fa-solid fa-download"></i> Exporter</a>
            </form>
            <br>
            <table class="table table-striped" id="tableMachines">
                <thead>
                    <tr>
                        <th>Numéro de série</th>
                        <th>Modèle</th>
                        <th>Type</th>
                        <th>Utilisateur</th>
                        <th>Service</th>
                        <th>Site</th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($machines as $machine)
                    <tr>
                        <td>{{ $machine->numero_serie ?? '—' }}</td>
                        <td>{{ $machine->modele ?? '—' }}</td>
                        <td>{{ $machine->type ?? '—' }}</td>
                        <td>{{ $machine->utilisateur ?? '—' }}</td>
                        <td>{{ $machine->service ?? '—' }}</td>
                        <td>{{ $machine->site ?? '—' }}</td>
                        <td>
                            <button type="button" class="btn btn-primary btn-edit-machine"
                                data-id="{{ $machine->id }}"
                                data-numero-serie="{{ $machine->numero_serie }}"
                                data-modele="{{ $machine->modele }}"
                                data-type="{{ $machine->type }}"
                                data-utilisateur="{{ $machine->utilisateur }}"
                                data-service="{{ $machine->service }}"
                                data-site="{{ $machine->site }}"
                                data-bs-toggle="modal" data-bs-target="#editMachineModal">
                                <i class="fa-solid fa-pen-to-square"></i> Modifier
                            </button>
                        </td>
                        <td>
                            <button type="button" class="btn btn-danger btn-delete-machine"
                                data-id="{{ $machine->id }}"
                                data-bs-toggle="modal" data-bs-target="#deleteMachineModal">
                                <i class="fa-solid fa-trash"></i> Supprimer
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Modal Modifier Machine -->
        <div class="modal fade" id="editMachineModal" tabindex="-1" aria-labelledby="editMachineModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editMachineModalLabel">Modifier la machine</h5>
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
                        <form id="editMachineForm" method="POST">
                            @csrf
                            @method('PUT')
                            <input type="hidden" id="editMachineId" name="id">
                            <div class="mb-3">
                                <label for="editNumeroSerie" class="form-label">Numéro de série</label>
                                <input type="text" class="form-control" name="numero_serie" id="editNumeroSerie">
                            </div>
                            <div class="mb-3">
                                <label for="editModele" class="form-label">Modèle</label>
                                <input type="text" class="form-control" name="modele" id="editModele">
                            </div>
                            <div class="mb-3">
                                <label for="editType" class="form-label">Type</label>
                                <input type="text" class="form-control" name="type" id="editType">
                            </div>
                            <div class="mb-3">
                                <label for="editUtilisateur" class="form-label">Utilisateur</label>
                                <input type="text" class="form-control" name="utilisateur" id="editUtilisateur">
                            </div>
                            <div class="mb-3">
                                <label for="editService" class="form-label">Service</label>
                                <input type="text" class="form-control" name="service" id="editService">
                            </div>
                            <div class="mb-3">
                                <label for="editSite" class="form-label">Site</label>
                                <input type="text" class="form-control" name="site" id="editSite">
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

        <!-- Modal Supprimer Machine -->
        <div class="modal fade" id="deleteMachineModal" tabindex="-1" aria-labelledby="deleteMachineModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteMachineModalLabel">Supprimer la machine</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Êtes-vous sûr de vouloir supprimer cette machine ?</p>
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
                        <form id="deleteMachineForm" method="POST">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" id="deleteMachineId" name="id">
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
    const table = document.getElementById('tableMachines');

    table.addEventListener('click', function(e) {
        const btn = e.target.closest('.btn-edit-machine');
        if (!btn) return;

        const id = btn.dataset.id;
        document.getElementById("editMachineId").value = id;
        document.getElementById("editNumeroSerie").value = btn.dataset.numeroSerie || '';
        document.getElementById("editModele").value = btn.dataset.modele || '';
        document.getElementById("editType").value = btn.dataset.type || '';
        document.getElementById("editUtilisateur").value = btn.dataset.utilisateur || '';
        document.getElementById("editService").value = btn.dataset.service || '';
        document.getElementById("editSite").value = btn.dataset.site || '';
        document.getElementById("editMachineForm").action = "/machines/update/" + id;
    });

    table.addEventListener('click', function(e) {
        const btn = e.target.closest('.btn-delete-machine');
        if (!btn) return;

        const id = btn.dataset.id;
        document.getElementById("deleteMachineId").value = id;
        document.getElementById("deleteMachineForm").action = "/machines/delete/" + id;
    });

    new simpleDatatables.DataTable("#tableMachines");
});
</script>
