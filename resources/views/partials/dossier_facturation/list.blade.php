<div class="container mt-5">

    <!-- TITRE -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold">
            <i class="fa-solid fa-folder-open me-2 text-primary"></i>
            <u>Liste des dossiers</u>
        </h4>
    </div>

    @if($dossiers->isEmpty())
        <div class="alert alert-info text-center">
            <i class="fa-solid fa-circle-info me-2"></i>
            Aucun dossier enregistré.
        </div>
    @else

    <!-- RECHERCHE -->
    <div class="mb-4 position-relative">
        <i class="fa fa-search position-absolute" 
           style="left: 15px; top: 12px; color: #999;"></i>

        <input type="text" id="searchInput" class="form-control ps-5 shadow-sm"
               placeholder="Rechercher par BL...">
    </div>

    <!-- CARD -->
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body p-4">

            <div class="table-responsive">
                <table class="table table-hover align-middle" id="dossiersTable">
                    <thead class="table-light">
                        <tr>
                            <th>
                                <i class="fa-solid fa-receipt me-1"></i>
                                BL
                            </th>
                            <th class="text-end">
                                Action
                            </th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach($dossiers as $dossier)
                        @php
                            $rattachement = $rattachements->firstWhere('id', $dossier->rattachement_bl_id);
                        @endphp

                        <tr class="hover-row">

                            <!-- BL -->
                            <td>
                                @if($rattachement)
                                    <span class="badge bg-light text-dark fs-6 border">
                                        {{ $rattachement->bl }}
                                    </span>
                                @else
                                    <span class="text-muted">
                                        <i class="fa-solid fa-triangle-exclamation me-1"></i>
                                        Rattachement non trouvé
                                    </span>
                                @endif
                            </td>

                            <!-- ACTION -->
                            <td class="text-end">
                                @if($rattachement)
                                    <a href="{{ route('dossier_facturation.show', $dossier->id) }}"
                                       class="btn btn-primary btn-sm px-3 rounded-pill">
                                        <i class="fa-solid fa-eye me-1"></i>
                                        Consulter
                                    </a>
                                @else
                                    <span class="text-muted">
                                        Aucun rattachement
                                    </span>
                                @endif
                            </td>

                        </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>

            <!-- PAGINATION -->
            <div class="mt-4 d-flex justify-content-center">
                {{ $dossiers->links('pagination::bootstrap-5') }}
            </div>

        </div>
    </div>
    @endif
</div>

<script>
    // Récupère la barre de recherche
    const searchInput = document.getElementById('searchInput');

    searchInput.addEventListener('keyup', function() {
        const filter = this.value.toLowerCase().trim();

        // Récupère toutes les lignes du tableau
        const rows = document.querySelectorAll('#dossiersTable tbody tr');

        rows.forEach(row => {
            // Récupère le texte du BL dans la première colonne
            const blCell = row.cells[0].textContent.toLowerCase();

            // Affiche ou cache la ligne selon le filtre
            if (blCell.includes(filter)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
</script>

