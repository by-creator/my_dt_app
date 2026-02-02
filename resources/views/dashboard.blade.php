@extends('partials.app')

@section('content')

<div id="app">
    <div id="main">

        <header class="mb-3">
            <a href="#" class="burger-btn d-block d-xl-none">
                <i class="bi bi-justify fs-3"></i>
            </a>
        </header>

        <div class="page-heading">
            <h3>Bienvenu(e) {{ $user->name }} </h3>
        </div>

        <div class="page-content">
            <div id="main-content">
                <section id="basic-input-groups">
                    <div class="row">
                        @if(Auth::user()->role->name == "CLIENT_FACTURATION" )
                        @include('dossier_facturation.index')
                        @else
                        <!-- BARRE DE RECHERCHE -->
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title text-center"><u>Effectuer une recherche</u></h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <div class="input-group mb-3">
                                            <span class="input-group-text">🔎</i></span>
                                            <input type="search" id="searchInput"
                                                class="form-control text-center"
                                                placeholder="Saisissez les éléments de recherche">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif

                        <!-- LES CARDS -->
                        <div class="row">
                            @foreach ($cards as $card)
                            <div class="col-md-3 mb-3">
                                <div class="card shadow-sm h-100" 
                                     data-card-id="{{ $card['id'] }}"
                                     data-card-name="{{ $card['header'] }}"> <!-- 👈 OBLIGATOIRE -->
                                    
                                    <div class="card-header bg-white text-white">
                                        <h5 class="card-title mb-0">
                                            <u>{{ $card['header'] }}</u>
                                        </h5>
                                    </div>

                                    <div class="card-body">
                                        <p class="card-text">{{ $card['description'] }}</p>
                                        <a href="{{ $card['route'] }}" class="btn btn-primary w-100">
                                            Ouvrir
                                        </a>
                                    </div>

                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>

<!-- SCRIPT DE RECHERCHE -->
<script>
document.addEventListener("DOMContentLoaded", function() {

    const searchInput = document.getElementById("searchInput");
    if (!searchInput) return;

    searchInput.addEventListener("input", function(e) {
        const searchQuery = e.target.value.toLowerCase().trim();

        const cards = document.querySelectorAll(".card[data-card-name]");

        cards.forEach((card) => {
            const cardName = card.getAttribute("data-card-name").toLowerCase();

            const wrapper = card.closest(".col-md-3");

            if (cardName.includes(searchQuery)) {
                wrapper.style.display = "";
            } else {
                wrapper.style.display = "none";
            }
        });
    });
});
</script>

@endsection
