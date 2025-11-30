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

    <!-- BARRE DE RECHERCHE -->
    <div class="mb-4 position-relative">
        <i class="fa fa-search position-absolute" 
           style="left: 15px; top: 12px; color: #999;"></i>

        <input type="text" id="searchInput" class="form-control ps-5 shadow-sm"
               placeholder="🔍 Rechercher par BL...">
    </div>

    <div class="row" id="cardContainer">

        @foreach($dossiers as $dossier)
        @php
            $rattachement = $rattachements->firstWhere('id', $dossier->rattachement_bl_id);
        @endphp

        <div class="col-md-4 col-lg-3 mb-4 dossier-card"
     data-bl="{{ $rattachement ? strtolower($rattachement->bl) : '' }}">

    <div class="card h-100 p-4 card-hover d-flex flex-column">

        <!-- ICÔNE MODERNE -->
        <div class="folder-icon mb-4">
            <i class="fa-solid fa-folder-open"></i>
        </div>

        <!-- BL -->
        <div class="text-center mb-4">
            @if($rattachement)
                <span class="badge-bl">
                    {{ $rattachement->bl }}
                </span>
            @else
                <span class="text-muted small">
                    Rattachement non trouvé
                </span>
            @endif
        </div>

        <!-- BOUTON -->
        <div class="mt-auto text-center">
            @if($rattachement)
                <a href="{{ route('dossier_facturation.show', $dossier->id) }}"
                   class="btn btn-modern">
                    <i class="fa-solid fa-eye me-1"></i>
                    Ouvrir
                </a>
            @else
                <span class="text-muted small">
                    Aucun rattachement
                </span>
            @endif
        </div>

    </div>
</div>


        @endforeach

    </div>

    <!-- Pagination -->
    <div class="mt-4 d-flex justify-content-center">
        {{ $dossiers->links('pagination::bootstrap-5') }}
    </div>

    @endif

</div>

<script>
    document.getElementById('searchInput').addEventListener('keyup', function() {
        const value = this.value.toLowerCase();
        const cards = document.querySelectorAll('.dossier-card');

        cards.forEach(card => {
            const bl = card.getAttribute('data-bl');

            if (bl.includes(value)) {
                card.style.display = "block";
            } else {
                card.style.display = "none";
            }
        });
    });
</script>
