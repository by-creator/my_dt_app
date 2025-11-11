<section class="section">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title"><u>Liste des rattachements en attente de validation</u></h4>
        </div>
        <div class="card-body">
            <table class="table table-striped" id="table1">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Agent</th>
                        <th>Nom & Prénom</th>
                        <th>Email</th>
                        <th>BL</th>
                        <th>Compte</th>
                        <th>Statut</th>
                        <th>Durée</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($rattachement_validations as $rattachement_validation)
                    <tr>
                        <td>{{ $rattachement_validation->created_at_date_formatted ?? '—' }}</td>
                        <td>
                            @php
                            $user = $users->firstWhere('id', $rattachement_validation->user_id);
                            @endphp
                            {{ $user ? $user->name : 'Agent non défini' }}
                        </td>
                        <td>{{ $rattachement_validation->nom }} {{ $rattachement_validation->prenom }}</td>
                        <td>{{ $rattachement_validation->email }}</td>
                        <td>{{ $rattachement_validation->bl }}</td>
                        <td>{{ $rattachement_validation->compte }}</td>
                        <td>{{ $rattachement_validation->statut }}</td>
                        <td>{{ $rattachement_validation->time_elapsed_for_humans ?? '—' }}</td>
                        <td>
                            <button type="button" class="btn btn-primary btn-delete" data-id="{{ $rattachement_validation->id }}" data-email="{{ $rattachement_validation->email }}" data-bs-toggle="modal" data-bs-target="#deleteModal"><i class="fa-solid fa-check-to-slot"></i> Valider</button>

                        </td>
                        <td>
                            <button type="button" class="btn btn-danger btn-edit" data-id="{{ $rattachement_validation->id }}" data-email="{{ $rattachement_validation->email }}"  data-bs-toggle="modal" data-bs-target="#editModal"><i class="fa-solid fa-square-xmark"></i> Rejeter</button>

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
                        <h5 class="modal-title" id="editModalLabel">Rejet du dossier</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        @if (session('invalide'))
                        <script>
                            Swal.fire({
                                icon: 'success',
                                title: 'Succès',
                                text: "{{ session('invalide') }}",
                                showConfirmButton: true
                            });
                        </script>
                         @elseif (session('error'))
                        <script>
                            Swal.fire({
                                icon: 'error',
                                title: 'Erreur',
                                text: "{{ session('error') }}",
                                showConfirmButton: true
                            });
                        </script>
                        @endif
                        <form id="editForm" method="POST">
                            @csrf
                            @method('PUT')
                            <input type="hidden" id="editId" name="id">
                            <input type="hidden" id="editEmail" name="email">
                            <div class="mb-3">
                                <label for="editNom" class="form-label">Êtes-vous sûr de vouloir rejeter ce dossier ?</label>
                                <textarea class="form-control" name="motif" rows="3" required placeholder="Merci de saisir le motif du refus de validation"></textarea>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary"><i class="fa-solid fa-check-to-slot"></i> Oui</button>
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><i class="fa-solid fa-square-xmark"></i> Non</button>
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
                        <h5 class="modal-title" id="deleteModalLabel">Valider le BL</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Êtes-vous sûr d'avoir valider ce dossier ?</p>
                        @if (session('valide'))
                        <script>
                            Swal.fire({
                                icon: 'success',
                                title: 'Succès',
                                text: "{{ session('valide') }}",
                                showConfirmButton: true
                            });
                        </script>
                        @elseif (session('error'))
                        <script>
                            Swal.fire({
                                icon: 'error',
                                title: 'Erreur',
                                text: "{{ session('error') }}",
                                showConfirmButton: true
                            });
                        </script>
                        @endif
                        <form id="deleteForm" method="POST">
                            @csrf
                            @method('PUT')
                            <input type="hidden" id="deleteId" name="id">
                            <input type="hidden" id="deleteEmail" name="email">
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
            const email = btn.dataset.email;
            document.getElementById("editId").value = id;
            document.getElementById("editEmail").value = btn.dataset.email || '';
            document.getElementById("editForm").action = "/rattachement/update/" + id;
        });

        // Event delegation pour Delete
        table.addEventListener('click', function(e) {
            const btn = e.target.closest('.btn-delete');
            if (!btn) return;

            const id = btn.dataset.id;
            const email = btn.dataset.email;
            document.getElementById("deleteId").value = id;
            document.getElementById("deleteEmail").value = email;
            document.getElementById("deleteForm").action = "/rattachement/delete/" + id;
        });

        // Initialiser la datatable
        new simpleDatatables.DataTable("#table1");
    });
</script>