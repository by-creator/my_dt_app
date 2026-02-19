<div class="container mt-4">

    <u>
        <h4 class="mb-4">
            <i class="bi bi-play-circle-fill"
                style="font-size: 30px; color: primary;">
            </i> <u>Liste des vidéos</u>
        </h4>
    </u>

    <!-- Barre de recherche -->
    <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title text-center"><u>Effectuer une recherche</u></h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <div class="input-group mb-3">
                                            <span class="input-group-text"><i class="fa-solid fa-magnifying-glass"></i></span>
                                            <input type="search" id="searchInput"
                                                class="form-control text-center"
                                                placeholder="Saisissez les éléments de recherche">
                                        </div>
                                    </div>
                                </div>
                            </div>
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

                    <a href="{{ $video['link'] }}"
                        target="_blank"
                        @if(isset($video['id'])) id="{{ $video['id'] }}" @endif>
                        <i class="bi bi-play-circle-fill"
                            style="font-size: 80px; color: primary;"></i>
                    </a>


                    <p class="mt-3">{{ $video['description'] }}</p>

                </div>

                <!-- FOOTER -->
                <div class="card-footer text-center">

                    <a href="{{ $video['link'] }}"
                        target="_blank"
                        class="btn btn-primary w-100"
                        @if(isset($video['id'])) id="{{ $video['id'] }}Btn" @endif>
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

<script>
    document.addEventListener("DOMContentLoaded", function() {

        // Liste des IDs de vidéos non disponibles
        const disabledVideos = ["videoPaiement", "videoReduction"];

        disabledVideos.forEach(id => {
            let el = document.getElementById(id);
            let btn = document.getElementById(id + "Btn");

            [el, btn].forEach(item => {
                if (item) {
                    item.addEventListener('click', function(e) {
                        e.preventDefault();
                        Swal.fire({
                            icon: 'info',
                            title: 'Information',
                            text: 'Cette vidéo n\'est pas encore disponible.',
                            confirmButtonText: 'OK'
                        });
                    });
                }
            });
        });

    });
</script>