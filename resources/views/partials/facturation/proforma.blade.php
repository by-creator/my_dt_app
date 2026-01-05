<section class="section">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title"><u>Gestion des proformas</u></h4>
        </div>
        <div class="card-body">
            <table class="table table-striped" id="table1">
                <thead>
                    <tr>
                        <th>Date & Heure</th>
                        <th>Agent</th>
                        <th>Numéro BL</th>
                        <th>Compte</th>
                        <th>Statut</th>
                        <th>Durée</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($dossiers as $dossier)
                        <tr>
                            <td>{{ $dossier->updated_at_date_formatted ?? '—' }}</td>
                            <td>
                                @php
                                    $user = $users->firstWhere('id', $dossier->user_id);
                                @endphp
                                {{ $user ? $user->name : 'Agent non défini' }}
                            </td>

                            <td>{{ $dossier->rattachement_bl ? $dossier->rattachement_bl->bl : '—' }}</td>
                            <td>{{ $dossier->rattachement_bl ? $dossier->rattachement_bl->compte : '—' }}</td>
                            <td>{{ $dossier->statut ?? '—' }}</td>
                            <td>{{ $dossier->time_elapsed_proforma ?? '-' }}</td>
                            <td>
                                <button type="button" class="btn btn-primary btn-send" data-id="{{ $dossier->id }}"
                                    data-email="{{ $dossier->email }}" data-bs-toggle="modal"
                                    data-bs-target="#sendModal"><i class="fa-solid fa-envelope"></i> Envoyer</button>
                            </td>
                            <td>
                                <button type="button" class="btn btn-danger btn-reject" data-id="{{ $dossier->id }}"
                                    data-email="{{ $dossier->email }}" data-bs-toggle="modal"
                                    data-bs-target="#rejetModal"><i class="fa-solid fa-square-xmark"></i>
                                    Rejeter</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="sendModal" tabindex="-1" aria-labelledby="sendModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="sendModalLabel">
                            Envoyer des documents
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <form id="sendProformaForm" method="POST" enctype="multipart/form-data">
                        @csrf
                        @if (session('successProforma'))
                                <script>
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Succès',
                                        text: "{{ session('successProforma') }}"
                                    });
                                </script>
                            @elseif (session('infoProforma'))
                                <script>
                                    Swal.fire({
                                        icon: 'info',
                                        title: 'Information',
                                        text: "{{ session('infoProforma') }}"
                                    });
                                </script>
                            @elseif (session('error'))
                                <script>
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Erreur',
                                        text: "{{ session('error') }}"
                                    });
                                </script>
                            @endif
                        <div class="modal-body">
                            <input type="hidden" name="dossier_id" id="proformaId">

                            <div class="mb-3">
                                <label class="form-label">Sélectionner un ou plusieurs fichiers</label>
                                <input type="file" name="proforma[]" class="form-control" multiple required>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa-solid fa-check-to-slot"></i> Oui
                            </button>
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                                <i class="fa-solid fa-square-xmark"></i> Non
                            </button>
                        </div>
                    </form>



                </div>
            </div>
        </div>

        <!-- Modal Rejeter -->
        <div class="modal fade" id="rejetModal" tabindex="-1" aria-labelledby="rejetModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="rejetModalLabel">Rejet de facture proforma</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="rejectForm" method="POST">
                            @if (session('success'))
                                <script>
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Succès',
                                        text: "{{ session('success') }}",
                                        showConfirmButton: true
                                    });
                                </script>
                            @endif
                            @csrf
                            @method('PUT')
                            <input type="hidden" id="rejectId" name="id">
                            <input type="hidden" id="rejectEmail" name="email">
                            <div class="mb-3">
                                <label for="motif" class="form-label">
                                    Êtes-vous sûr de vouloir rejeter cette demande de proforma ?
                                </label>

                                <select class="form-select" name="motif" id="motif" required>
                                    <option value="" disabled selected>-- Sélectionnez le motif du refus --
                                    </option>
                                    <option value="La proforma de ce dossier à déjà été traitée">La proforma de ce
                                        dossier à déjà été traitée</option>
                                    <option value="autre">Autre motif</option>
                                </select>
                            </div>

                            <div class="mb-3 d-none" id="autreMotifContainer">
                                <label for="autreMotif" class="form-label">
                                    Merci de préciser le motif
                                </label>
                                <textarea class="form-control" name="autreMotif" id="autreMotif" rows="3"
                                    placeholder="Saisissez le motif du refus"></textarea>
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
