<div class="col-md-12 col-12">
    <div class="card">

        <div class="card-header">
            <h4 class="card-title">
                <u>Liste des téléphones mobiles</u>
            </h4>
        </div>

        <div class="card-body">

            {{-- 🔍 Filtres --}}
            @include('partials.stock.telephone_mobiles.filters')

            {{-- 📋 Tableau --}}
            @include('partials.stock.telephone_mobiles.table')

            {{-- 📑 Pagination --}}
            <div class="d-flex justify-content-between align-items-center mt-3">
                <div class="small text-muted">
                    Affichage de {{ $telephones->firstItem() }} à {{ $telephones->lastItem() }}
                    sur {{ $telephones->total() }} résultats
                </div>

                <div>
                    {{ $telephones->links() }}
                </div>
            </div>

        </div>
    </div>
</div>

{{-- ✏️ Modals --}}
@include('partials.stock.telephone_mobiles.modals.edit')
@include('partials.stock.telephone_mobiles.modals.delete')

{{-- 🔔 Toasts --}}
@include('partials.stock.telephone_mobiles.toasts')

{{-- ⚙️ Scripts JS --}}
@include('partials.stock.telephone_mobiles.scripts')
