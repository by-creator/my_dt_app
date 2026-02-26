<div class="col-md-12 col-12">
    <div class="card">

        <div class="card-header">
            <h4 class="card-title">
                <u>Liste des items</u>
            </h4>
        </div>

        <div class="card-body">

            {{-- 🔍 Filtres --}}
            @include('partials.rattachement_bl.filters_remise')

            {{-- 📋 Tableau --}}
            @include('partials.rattachement_bl.table_remise')

            {{-- 📑 Pagination --}}
            <div class="d-flex justify-content-between align-items-center mt-3">
                <div class="small text-muted">
                    Affichage de {{ $remisesTraitees->firstItem() }} à {{ $remisesTraitees->lastItem() }}
                    sur {{ $remisesTraitees->total() }} résultats
                </div>

                <div>
                    {{ $remisesTraitees->links() }}
                </div>
            </div>

        </div>
    </div>
</div>

{{-- 🔔 Toasts --}}
@include('partials.toasts')

{{-- ⚙️ Scripts JS --}}
@include('partials.rattachement_bl.scripts_remise')
