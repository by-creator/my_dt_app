<section class="section">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title"><u>Liste des bons à délivrer</u></h4>
        </div>
        <div class="card-body">
            <table class="table table-striped" id="table1">
                <thead>
                    <tr>
                        <th>Date & Heure</th>
                        <th>Agent</th>
                        <th>Numéro BL</th>
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
                        <td>{{ $dossier->statut ?? '—' }}</td>
                        <td>{{ $dossier->time_elapsed_bon ?? '-' }}</td>
                        <td>
                            <button type="button" class="btn btn-primary btn-delete" data-id="{{ $dossier->id }}" data-email="{{ $dossier->email }}" data-bs-toggle="modal" data-bs-target="#sendModal"><i class="fa-solid fa-envelope"></i> Envoyer le(s) document(s)</button>
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

                    <form id="sendBonForm" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="modal-body">
                            <p>Êtes-vous sûr de vouloir envoyer le(s) document(s) pour ce dossier ?</p>

                            <input type="hidden" name="dossier_id" id="bonId">
                            <input type="hidden" name="email" id="deleteEmail">

                            <div class="mb-3">
                                <label class="form-label">Sélectionner un ou plusieurs fichiers</label>
                                <input
                                    type="file"
                                    name="bon[]"
                                    class="form-control"
                                    multiple
                                    required>
                            </div>

                            @if (session('successBon'))
                            <script>
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Succès',
                                    text: "{{ session('successBon') }}"
                                });
                            </script>
                            @elseif (session('infoBon'))
                            <script>
                                Swal.fire({
                                    icon: 'info',
                                    title: 'Information',
                                    text: "{{ session('infoBon') }}"
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


    </div>

</section>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const table = document.getElementById('table1');

        // Event delegation pour Delete
        table.addEventListener('click', function(e) {
            const btn = e.target.closest('.btn-delete');
            if (!btn) return;

            const id = btn.dataset.id;
            document.getElementById("bonId").value = id;
            document.getElementById("sendBonForm").action = "/dossier-facturation/bon/send/" + id;
        });

        // Initialiser la datatable
        new simpleDatatables.DataTable("#table1");
    });
</script>