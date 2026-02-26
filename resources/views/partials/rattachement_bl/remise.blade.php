<section class="section">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title"><u>Gestion des demandes de remise</u></h4>
        </div>
        <div class="card-body">
            <table class="table" id="table1">
                <thead>
                    <tr>
                        <th>Date & Heure</th>
                        <th>Client</th>
                        <th>Email</th>
                        <th>BL</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($remisesAValider as $remise)
                        <tr>
                            <td>{{ $remise->created_at_date_formatted ?? '—' }}</td>
                            <td>{{ $remise->nom }} {{ $remise->prenom }}</td>
                            <td>{{ $remise->email }}</td>
                            <td>{{ $remise->bl }}</td>
                            <td>{{ $remise->statut }}</td>
                            <td class="d-flex gap-2">
                                <button type="button" class="btn btn-sm btn-outline-primary me-2 btn-validate"
                                    data-id="{{ $remise->id }}"
                                    data-email="{{ $remise->email }}" data-bs-toggle="modal"
                                    data-bs-target="#valideModal">
                                    <i class="fa-solid fa-check-to-slot"></i> Valider
                                </button>

                                <button type="button" class="btn btn-sm btn-outline-danger me-2 btn-reject"
                                    data-id="{{ $remise->id }}"
                                    data-email="{{ $remise->email }}" data-bs-toggle="modal"
                                    data-bs-target="#rejetModal">
                                    <i class="fa-solid fa-square-xmark"></i> Rejeter
                                </button>
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
                        <form id="sendRemiseForm" method="POST">
                            @csrf
                            @method('PUT')
                            <input type="hidden" id="sendRemiseId" name="id">
                            <input type="hidden" id="sendRemiseEmail" name="email">
                            @if (Auth::user()->role->name == 'ADMIN' || Auth::user()->role->name == 'DIRECTION_GENERALE')
                                <div class="mb-3">
                                    <label for="pourcentage" class="form-label">
                                        Pourcentage de remise (%)
                                    </label>
                                    <input type="number" name="pourcentage" id="pourcentage" class="form-control"
                                        min="0" max="100" step="0.01" required>
                                </div>
                            @endif
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-outline-primary"><i class="fa-solid fa-check-to-slot"></i>
                                    Oui</button>
                                <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal"><i
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
                    <form id="rejectRemiseForm" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" id="rejectRemiseId" name="id">
                        <input type="hidden" id="rejectRemiseEmail" name="email">
                        <div class="mb-3">
                            <label for="motif" class="form-label">
                                Êtes-vous sûr de vouloir rejeter ce dossier ?
                            </label>
                            <select class="form-select" name="motif" id="motif" required>
                                <option value="" disabled selected>
                                    -- Sélectionnez le motif du refus --
                                </option>
                                <option value="La documentation n'est pas
                                    valide">La documentation n'est pas
                                    valide</option>
                                <option value="autre">Autre motif</option>
                            </select>
                        </div>

                        <div class="mb-3" id="autreMotifDiv" style="display: none;">
                            <label for="autreMotif" class="form-label">
                                Veuillez spécifier votre motif :
                            </label>
                            <textarea class="form-control" name="autreMotif" id="autreMotif" rows="3"
                                placeholder="Entrez votre motif ici"></textarea>
                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-outline-primary"><i class="fa-solid fa-check-to-slot"></i>
                                Oui</button>
                            <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal"><i
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
        const motifSelect = document.getElementById("motif");
        const autreMotifDiv = document.getElementById("autreMotifDiv");

        // Lorsque l'utilisateur sélectionne un motif
        motifSelect.addEventListener("change", function() {
            if (motifSelect.value === "autre") {
                // Afficher le champ texte si "Autre motif" est sélectionné
                autreMotifDiv.style.display = "block";
            } else {
                // Cacher le champ texte si une autre option est sélectionnée
                autreMotifDiv.style.display = "none";
            }
        });

        const table = document.getElementById('table1');

        // Event delegation pour valider
        table.addEventListener('click', function(e) {
            const btn = e.target.closest('.btn-validate');
            if (!btn) return;

            const id = btn.dataset.id;
            const email = btn.dataset.email;
            document.getElementById("sendRemiseId").value = id;
            document.getElementById("sendRemiseEmail").value = email;
            document.getElementById("sendRemiseForm").action = "/rattachement/remise/send/" +
                id;
        });

        // Event delegation pour rejeter
        table.addEventListener('click', function(e) {
            const btn = e.target.closest('.btn-reject');
            if (!btn) return; // Si ce n'est pas un bouton edit, on ignore

            const id = btn.dataset.id;
            const email = btn.dataset.email;
            document.getElementById("rejectRemiseId").value = id;
            document.getElementById("rejectRemiseEmail").value = btn.dataset.email || '';
            document.getElementById("rejectRemiseForm").action = "/rattachement/remise/reject/" + id;
        });

        // Initialiser la datatable
        new simpleDatatables.DataTable("#table1");
    });
</script>
