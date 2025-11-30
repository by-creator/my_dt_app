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

            <div class="card h-100 shadow-sm border-0 rounded-4 p-3 card-hover">

                <!-- ICÔNE -->
                <div class="text-center mb-3">
                    <i class="fa-solid fa-folder-open text-primary"
                       style="font-size: 50px;"></i>
                </div>

                <!-- BL -->
                <h6 class="text-center mb-3">

                    @if($rattachement)
                    <span class="badge bg-light text-dark border px-3 py-2">
                        {{ $rattachement->bl }}
                    </span>
                    @else
                    <span class="text-muted">
                        Rattachement non trouvé
                    </span>
                    @endif

                </h6>

                <!-- ACTION -->
                <div class="mt-auto text-center">
                    @if($rattachement)
                    <a href="{{ route('dossier_facturation.show', $dossier->id) }}"
                       class="btn btn-primary btn-sm rounded-pill px-4">
                        <i class="fa-solid fa-eye me-1"></i>
                        Consulter
                    </a>
                    @else
                    <span class="text-muted">
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
