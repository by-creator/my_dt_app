<div class="container mt-5 d-flex justify-content-center">
    <div class="card w-50">
        <div class="card-header text-center">
            <h4 class="card-title"><u>Entrez un numéro d'item</u></h4>
        </div>
        <div class="card-content">
            <div class="card-body">

                <form method="POST" action="{{ route('ordre_approche.list') }}">
                    @csrf

                    <div class="row justify-content-center">
                        <div class="col-md-8 col-12">
                            <div class="form-group">
                                <label>Item number</label>
                                <input type="text" class="form-control"
                                       name="item_number"
                                       id="input-item_number"
                                       list="datalist-item_number"
                                       placeholder="Saisir un numéro d'item">
                                <datalist id="datalist-item_number"></datalist>
                            </div>

                            <div class="d-flex justify-content-center mt-3">
                                <button type="submit" class="btn btn-sm btn-outline-primary me-2">
                                    <i class="fa-solid fa-check-to-slot"></i> Valider
                                </button>
                                <button type="reset" class="btn btn-sm btn-outline-primary">
                                    <i class="fa-solid fa-square-xmark"></i> Annuler
                                </button>
                            </div>
                        </div>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>

<script>
function setupDatalist(inputId, datalistId, field) {
    const input = document.getElementById(inputId);
    const datalist = document.getElementById(datalistId);
    let controller;

    input.addEventListener('input', function () {
        const value = this.value.trim();

        if (value.length < 1) {
            datalist.innerHTML = '';
            return;
        }

        // ⛔ annule la requête précédente
        if (controller) controller.abort();
        controller = new AbortController();

        fetch(`{{ route('ordre_approche.datalist') }}?field=${field}&q=${encodeURIComponent(value)}`, {
            signal: controller.signal
        })
        .then(res => res.json())
        .then(data => {
            datalist.innerHTML = '';
            data.forEach(item => {
                const option = document.createElement('option');
                option.value = item;
                datalist.appendChild(option);
            });
        })
        .catch(err => {
            if (err.name !== 'AbortError') console.error(err);
        });
    });
}

// 🔌 Initialisation
setupDatalist('input-item_number', 'datalist-item_number', 'item_number');


</script>
