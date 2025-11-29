<div class="container mt-4">

    <u>
        <h4 class="mb-4">Liste des dossiers</h4>
    </u>
    @if($dossiers->isEmpty())
    <p class="text-muted text-center">Aucun dossier enregistré.</p>
    @else
    <!-- Barre de recherche -->
    <div class="mb-3">
        <input type="text" id="searchInput" class="form-control" placeholder="Rechercher par BL...">
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-hover" id="dossiersTable">
            <thead class="table-white">
                <tr>
                    <th>Numéro de BL</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($dossiers as $dossier)
                <tr>
                    <td>
                        @php
                        $rattachement = $rattachements->firstWhere('id', $dossier->rattachement_bl_id);
                        @endphp
                        {{ $rattachement ? $rattachement->bl : 'Rattachement non trouvé' }}
                    </td>
                    <td>
                        @if($rattachement)
                        <a href="{{ route('dossier_facturation.show', $rattachement->id) }}"
                            class="btn btn-sm btn-primary">
                            <i class="fa-solid fa-eye"></i> Consulter
                        </a>
                        @else
                        <span class="text-muted">Aucun rattachement</span>
                        @endif
                    </td>
                </tr>
                @endforeach


            </tbody>
        </table>
    </div>

    <!-- Pagination Bootstrap -->
    <div class="mt-3">
        {{ $dossiers->links('pagination::bootstrap-5') }}
    </div>
    @endif
</div>

<script>
    document.getElementById('searchInput').addEventListener('keyup', function() {
        let filter = this.value.trim();
        let rows = document.querySelectorAll('#dossiersTable tbody tr');

        rows.forEach(row => {
            let id = row.cells[0].textContent;
            row.style.display = id.includes(filter) ? '' : 'none';
        });
    });
</script>