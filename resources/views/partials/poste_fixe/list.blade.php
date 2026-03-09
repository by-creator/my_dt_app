<section class="section">
    <div class="card">
        <div class="card-header">
            <h4><u>Liste des postes fixes</u></h4>
        </div>
        <div class="card-body">
            <form action="{{ route('poste_fixes.import') }}" method="post" enctype="multipart/form-data">
                @csrf
                <input class="form-control form-control-md" id="formFilePosteFixe" type="file" name="file" accept=".xlsx,.csv">
                <br>
                <button type="submit" class="btn btn-primary"><i class="fa-solid fa-upload"></i> Importer</button>
                <a href="{{ route('poste_fixes.export') }}" class="btn btn-danger"><i class="fa-solid fa-download"></i> Exporter</a>
            </form>
            <br>
            <table class="table table-striped" id="tablePosteFixes">
                <thead>
                    <tr>
                        <th>Annuaire</th>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Type</th>
                        <th>Entité</th>
                        <th>Rôle</th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($poste_fixes as $poste)
                    <tr>
                        <td>{{ $poste->annuaire ?? '—' }}</td>
                        <td>{{ $poste->nom ?? '—' }}</td>
                        <td>{{ $poste->prenom ?? '—' }}</td>
                        <td>{{ $poste->type ?? '—' }}</td>
                        <td>{{ $poste->entite ?? '—' }}</td>
                        <td>{{ $poste->role ?? '—' }}</td>
                        <td>
                            <button type="button" class="btn btn-primary btn-edit-poste"
                                data-id="{{ $poste->id }}"
                                data-annuaire="{{ $poste->annuaire }}"
                                data-nom="{{ $poste->nom }}"
                                data-prenom="{{ $poste->prenom }}"
                                data-type="{{ $poste->type }}"
                                data-entite="{{ $poste->entite }}"
                                data-role="{{ $poste->role }}"
                                data-bs-toggle="modal" data-bs-target="#editPosteFixeModal">
                                <i class="fa-solid fa-pen-to-square"></i> Modifier
                            </button>
                        </td>
                        <td>
                            <button type="button" class="btn btn-danger btn-delete-poste"
                                data-id="{{ $poste->id }}"
                                data-bs-toggle="modal" data-bs-target="#deletePosteFixeModal">
                                <i class="fa-solid fa-trash"></i> Supprimer
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Modal Modifier Poste Fixe -->
        <div class="modal fade" id="editPosteFixeModal" tabindex="-1" aria-labelledby="editPosteFixeModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editPosteFixeModalLabel">Modifier le poste fixe</h5>
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
                        <form id="editPosteFixeForm" method="POST">
                            @csrf
                            @method('PUT')
                            <input type="hidden" id="editPosteFixeId" name="id">
                            <div class="mb-3">
                                <label for="editAnnuaire" class="form-label">Annuaire</label>
                                <input type="text" class="form-control" name="annuaire" id="editAnnuaire">
                            </div>
                            <div class="mb-3">
                                <label for="editNom" class="form-label">Nom</label>
                                <input type="text" class="form-control" name="nom" id="editNom">
                            </div>
                            <div class="mb-3">
                                <label for="editPrenom" class="form-label">Prénom</label>
                                <input type="text" class="form-control" name="prenom" id="editPrenom">
                            </div>
                            <div class="mb-3">
                                <label for="editTypePoste" class="form-label">Type</label>
                                <input type="text" class="form-control" name="type" id="editTypePoste">
                            </div>
                            <div class="mb-3">
                                <label for="editEntite" class="form-label">Entité</label>
                                <input type="text" class="form-control" name="entite" id="editEntite">
                            </div>
                            <div class="mb-3">
                                <label for="editRole" class="form-label">Rôle</label>
                                <input type="text" class="form-control" name="role" id="editRole">
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

        <!-- Modal Supprimer Poste Fixe -->
        <div class="modal fade" id="deletePosteFixeModal" tabindex="-1" aria-labelledby="deletePosteFixeModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deletePosteFixeModalLabel">Supprimer le poste fixe</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Êtes-vous sûr de vouloir supprimer ce poste fixe ?</p>
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
                        <form id="deletePosteFixeForm" method="POST">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" id="deletePosteFixeId" name="id">
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
    const table = document.getElementById('tablePosteFixes');

    table.addEventListener('click', function(e) {
        const btn = e.target.closest('.btn-edit-poste');
        if (!btn) return;

        const id = btn.dataset.id;
        document.getElementById("editPosteFixeId").value = id;
        document.getElementById("editAnnuaire").value = btn.dataset.annuaire || '';
        document.getElementById("editNom").value = btn.dataset.nom || '';
        document.getElementById("editPrenom").value = btn.dataset.prenom || '';
        document.getElementById("editTypePoste").value = btn.dataset.type || '';
        document.getElementById("editEntite").value = btn.dataset.entite || '';
        document.getElementById("editRole").value = btn.dataset.role || '';
        document.getElementById("editPosteFixeForm").action = "/poste-fixes/update/" + id;
    });

    table.addEventListener('click', function(e) {
        const btn = e.target.closest('.btn-delete-poste');
        if (!btn) return;

        const id = btn.dataset.id;
        document.getElementById("deletePosteFixeId").value = id;
        document.getElementById("deletePosteFixeForm").action = "/poste-fixes/delete/" + id;
    });

    new simpleDatatables.DataTable("#tablePosteFixes");
});
</script>
