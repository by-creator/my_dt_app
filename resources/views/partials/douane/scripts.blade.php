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

        fetch(`{{ route('yard.datalist') }}?field=${field}&q=${encodeURIComponent(value)}`, {
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
