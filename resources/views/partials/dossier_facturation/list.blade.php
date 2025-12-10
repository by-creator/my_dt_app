<div class="container mt-5">

    <!-- TITRE -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold">
            <i class="fa-solid fa-folder-open me-2 text-primary"></i>
            <u>Liste des dossiers</u>
        </h4>
    </div>

    @if($dossiers->isEmpty())
        <div class="alert alert-primary text-center">
            <i class="fa-solid fa-circle-info me-2"></i>
            Aucun dossier enregistré.
        </div>
    @else

    <!-- BARRE DE RECHERCHE -->
    <div class="mb-4 position-relative">
        <i class="fa fa-search position-absolute" 
           style="left: 15px; top: 12px; color: #999;"></i>

        <input type="text" id="searchInput" class="form-control ps-5 shadow-sm"
               placeholder="🔍 Rechercher par BL...">
    </div>

    <!-- LISTE DES DOSSIERS EN CARDS -->
    <div class="row" id="cardsContainer">
        @foreach($dossiers as $dossier)

        @php
            $rattachement = $rattachements->firstWhere('id', $dossier->rattachement_bl_id);
            $bl = $rattachement ? $rattachement->bl : null;
        @endphp

        <div class="col-md-4 mb-4 dossier-card" data-bl="{{ strtolower($bl) }}">
            <div class="card h-100 shadow-sm d-flex flex-column">

                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <span class="badge bg-light text-dark">
                        {{ $bl ?? 'N/A' }}
                    </span>
                </div>

                <div class="card-body d-flex flex-column">

                    @if(!$bl)
                        <p class="text-muted mb-3">
                            Aucun dossier trouvé
                        </p>
                    @endif

                    <div class="mt-auto">
                        @if($bl)
                            <a href="{{ route('dossier_facturation.show', $dossier->id) }}"
                               class="btn btn-primary w-100">
                               <i class="fa-solid fa-eye me-1"></i> Ouvrir
                            </a>
                        @endif
                    </div>
                </div>

            </div>
        </div>

        @endforeach
    </div>

    <!-- PAGINATION -->
    <div class="mt-4 d-flex justify-content-center">
        {{ $dossiers->links('pagination::bootstrap-5') }}
    </div>

    @endif

</div>

<script>
document.getElementById('searchInput').addEventListener('keyup', function() {
    const filter = this.value.toLowerCase().trim();
    const cards = document.querySelectorAll('.dossier-card');

    cards.forEach(card => {
        const bl = card.getAttribute('data-bl');

        if (bl && bl.includes(filter)) {
            card.style.display = '';
        } else {
            card.style.display = 'none';
        }
    });
});
</script>
