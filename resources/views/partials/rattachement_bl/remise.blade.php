<section class="section">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title"><u>Gestion des demandes de remise</u></h4>
        </div>
        <div class="card-body">
            <table class="table table-striped" id="table1">
                <thead>
                    <tr>
                        <th>Date & Heure</th>
                        <th>Nom & Prénom</th>
                        <th>BL</th>
                        <th>Compte</th>
                        <th>Statut</th>
                        <th>Durée</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($rattachement_remises as $rattachement_remise)
                        <tr>
                            <td>{{ $rattachement_remise->created_at_date_formatted ?? '—' }}</td>
                            <td>{{ $rattachement_remise->nom }} {{ $rattachement_remise->prenom }}</td>
                            <td>{{ $rattachement_remise->bl }}</td>
                            <td>{{ $rattachement_remise->compte }}</td>
                            <td>{{ $rattachement_remise->statut }}</td>
                            <td>{{ $rattachement_remise->time_elapsed ?? '—' }}</td>
                            <td>
                                <button type="button" class="btn btn-primary btn-delete"
                                    data-id="{{ $rattachement_remise->id }}"
                                    data-email="{{ $rattachement_remise->email }}" data-bs-toggle="modal"
                                    data-bs-target="#valideModal"><i class="fa-solid fa-check-to-slot"></i>
                                    Valider</button>

                            </td>
                            <td>
                                <button type="button" class="btn btn-danger btn-edit"
                                    data-id="{{ $rattachement_remise->id }}"
                                    data-email="{{ $rattachement_remise->email }}" data-bs-toggle="modal"
                                    data-bs-target="#rejetModal"><i class="fa-solid fa-square-xmark"></i>
                                    Rejeter</button>

                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Modal Valider -->
        <div class="modal fade" id="valideModal" tabindex="-1" aria-labelledby="valideModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="valideModalLabel">Valider le BL</h5>
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
                                <button type="submit" class="btn btn-primary"><i class="fa-solid fa-check-to-slot"></i>
                                    Oui</button>
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><i
                                        class="fa-solid fa-square-xmark"></i> Non</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Rejeter -->
<div class="modal fade" id="rejetModal" tabindex="-1" aria-labelledby="rejetModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="rejetModalLabel">Rejet du dossier</h5>
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
                        <label for="motif" class="form-label">
                            Êtes-vous sûr de vouloir rejeter ce dossier ?
                        </label>
                        <select class="form-select" name="motif" id="motif" required>
                            <option value="" disabled selected>
                                -- Sélectionnez le motif du refus --
                            </option>
                            <option value="Le débarquement n'est pas encore effectif">Le débarquement n'est pas encore effectif</option>
                            <option value="autre">Autre motif</option>
                        </select>
                    </div>

                    <div class="mb-3" id="autreMotifDiv" style="display: none;">
                        <label for="autreMotif" class="form-label">
                            Veuillez spécifier votre motif :
                        </label>
                        <textarea class="form-control" name="autreMotif" id="autreMotif" rows="3" placeholder="Entrez votre motif ici"></textarea>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary"><i class="fa-solid fa-check-to-slot"></i>
                            Oui</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><i
                                class="fa-solid fa-square-xmark"></i> Non</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


</section>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const table = document.getElementById('table1');

        table.addEventListener('click', function(e) {
            const btn = e.target.closest('.btn-send');
            if (!btn) return;

            const id = btn.dataset.id;

            const form = document.getElementById("sendProformaForm");
            form.action = `/dossier-facturation/proforma/send/${id}`;

            document.getElementById("proformaId").value = id;
        });
    });
</script>


<script>
    document.addEventListener("DOMContentLoaded", function() {
        const table = document.getElementById('table1');
        const motifSelect = document.getElementById("motif");
        const autreMotifContainer = document.getElementById("autreMotifContainer");

        // Event delegation pour envoyer des documents
        table.addEventListener('click', function(e) {
            const btn = e.target.closest('.btn-send');
            if (!btn) return;

            const id = btn.dataset.id;
            document.getElementById("proformaId").value = id;
            document.getElementById("sendProformaForm").action = "/dossier-facturation/proforma/send/" +
                id;
        });

        // Event delegation pour rejeter un dossier
        table.addEventListener('click', function(e) {
            const btn = e.target.closest('.btn-reject');
            if (!btn) return; // Si ce n'est pas un bouton reject, on ignore

            const id = btn.dataset.id;
            const email = btn.dataset.email;

            document.getElementById("rejectId").value = id;
            document.getElementById("rejectEmail").value = email;
            document.getElementById("rejectForm").action = "/dossier-facturation/proforma/reject/" + id;
        });

        // Affichage du champ 'Autre motif' selon la sélection
        motifSelect.addEventListener("change", function() {
            if (motifSelect.value === "autre") {
                // Afficher le champ texte si "Autre motif" est sélectionné
                autreMotifContainer.classList.remove("d-none");
            } else {
                // Cacher le champ texte si une autre option est sélectionnée
                autreMotifContainer.classList.add("d-none");
            }
        });

        // Initialiser la datatable
        new simpleDatatables.DataTable("#table1");
    });
</script>
