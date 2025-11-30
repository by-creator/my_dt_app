<div class="container mt-4">

    <u>
        <h4 class="mb-4">
            <i class="bi bi-play-circle-fill"
                style="font-size: 30px; color: primary;">
            </i> <u>Liste des vidéos</u>
        </h4>
    </u>

    <!-- Barre de recherche -->
    <div class="mb-4">
        <input type="text" id="searchInput" class="form-control"
            placeholder="🔍 Rechercher une vidéo par titre...">
    </div>

    <div class="row" id="videoContainer">

        @foreach($videos as $video)
        <div class="col-md-4 mb-4 video-card" data-title="{{ strtolower($video['title']) }}">

            <div class="card h-100 shadow-sm">

                <!-- HEADER -->
                <div class="card-header text-center fw-bold">
                    <u>{{ $video['title'] }}</u>
                </div>

                <!-- BODY -->
                <div class="card-body text-center">

                    <a href="{{ $video['link'] }}" target="_blank">
                        <i class="bi bi-play-circle-fill"
                            style="font-size: 80px; color: primary;"></i>
                    </a>

                    <p class="mt-3">{{ $video['description'] }}</p>

                </div>

                <!-- FOOTER -->
                <div class="card-footer text-center">

                    <a href="{{ $video['link'] }}" target="_blank"
                        class="btn btn-primary w-100">
                        ▶ Regarder la vidéo
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
        const videos = document.querySelectorAll('.video-card');

        videos.forEach(video => {
            const title = video.getAttribute('data-title');

            if (title.includes(searchValue)) {
                video.style.display = "block";
            } else {
                video.style.display = "none";
            }
        });

    });
</script>