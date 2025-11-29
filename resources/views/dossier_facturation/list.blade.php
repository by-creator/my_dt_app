
<div class="container mt-4">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title"><u>Liste des dossiers</u></h4>
            @if($dossiers->isEmpty())
            <p class="text-muted">Aucun dossier enregistré.</p>
            @else
        </div>
        <div class="card-body">
            <table class="table table-striped" id="table1">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($dossiers as $dossier)
                    <tr>
                        <td>{{ $dossier->id }}</td>
                        <td>
                            <a href="{{ route('dossier_facturation.show', $dossier->id) }}" class="btn btn-sm btn-primary">
                                Voir les documents
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif
</div>

<!-- Script pour filtrer par ID -->
<script>
    document.getElementById('searchInput').addEventListener('keyup', function() {
        let filter = this.value.trim();
        let rows = document.querySelectorAll('#dossiersTable tbody tr');

        rows.forEach(row => {
            let id = row.cells[0].textContent;
            if (id.includes(filter)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
</script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const table = document.getElementById('table1');

        // Event delegation pour Edit
        table.addEventListener('click', function(e) {
            const btn = e.target.closest('.btn-edit');
            if (!btn) return; // Si ce n'est pas un bouton edit, on ignore

            const id = btn.dataset.id;
            document.getElementById("editId").value = id;
            document.getElementById("editName").value = btn.dataset.name || '';
            document.getElementById("editForm").action = "/role/update/" + id;
        });

        // Event delegation pour Delete
        table.addEventListener('click', function(e) {
            const btn = e.target.closest('.btn-delete');
            if (!btn) return;

            const id = btn.dataset.id;
            document.getElementById("deleteId").value = id;
            document.getElementById("deleteForm").action = "/role/delete/" + id;
        });

        // Initialiser la datatable
        new simpleDatatables.DataTable("#table1");
    });
</script>
