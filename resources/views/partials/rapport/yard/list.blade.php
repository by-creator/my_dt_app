<div class="col-md-12 col-12">
    <div class="card">

        <div class="card-header">
            <h4 class="card-title">
                <u>Liste des items</u>
            </h4>
        </div>

        <div class="card-body">

            {{-- 🔍 Filtres --}}
            @include('partials.rapport.yard.filters')

            {{-- 📋 Tableau --}}
            @include('partials.rapport.yard.table')

            {{-- 📑 Pagination --}}
            <div class="d-flex justify-content-between align-items-center mt-3">
                <div class="small text-muted">
                    Affichage de {{ $yards->firstItem() }} à {{ $yards->lastItem() }}
                    sur {{ $yards->total() }} résultats
                </div>

                <div>
                    {{ $yards->links() }}
                </div>
            </div>

        </div>
    </div>
</div>

{{-- 🔔 Toasts --}}
@include('partials.toasts')

{{-- ⚙️ Scripts JS --}}
@include('partials.rapport.yard.scripts')
