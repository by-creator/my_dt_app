<div class="container mt-4">

    <u>
        <h4 class="mb-4">
            <i class="bi bi-file-earmark-pdf-fill" style="font-size:30px; color:primary"></i> 

            <u>Liste des documents PDF</u>
        </h4>
    </u>

    <!-- Barre de recherche -->
    <div class="mb-4">
        <input type="text" id="searchInput" class="form-control"
            placeholder="🔍 Rechercher un document par titre...">
    </div>

    <div class="row" id="pdfContainer">

        @foreach($pdfs as $pdf)
        <div class="col-md-4 mb-4 pdf-card" data-title="{{ strtolower($pdf['title']) }}">

            <div class="card h-100 shadow-sm">

                <!-- HEADER -->
                <div class="card-header text-center fw-bold">
                    <u>{{ $pdf['title'] }}</u>
                </div>

                <!-- BODY -->
                <div class="card-body text-center">

                    <a href="{{ $pdf['link'] }}" target="_blank">
                        <i class="bi bi-file-earmark-pdf-fill" style="font-size:80px; color:primary"></i>


                    </a>

                    <p class="mt-3">{{ $pdf['description'] }}</p>

                </div>

                <!-- FOOTER -->
                <div class="card-footer text-center">

                    <a href="{{ $pdf['link'] }}" target="_blank"
                        class="btn btn-primary w-100">
                        📄 Ouvrir le PDF
                    </a>

                </div>

            </div>

        </div>
        @endforeach

    </div>

</div>

<script>
    document.getElementById('searchInput').addEventListener('keyup', function() {

        const searchValue = this.value.toLowerCase();
        const pdfs = document.querySelectorAll('.pdf-card');

        pdfs.forEach(pdf => {
            const title = pdf.getAttribute('data-title');

            if (title.includes(searchValue)) {
                pdf.style.display = "block";
            } else {
                pdf.style.display = "none";
            }
        });

    });
</script>