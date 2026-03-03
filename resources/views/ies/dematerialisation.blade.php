<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dakar-Terminal</title>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background: #f4f7fb;
        }

        /* HERO */
        .menu-hero {
            background: linear-gradient(135deg, #0d6efd, #3d8bfd);
            color: white;
            padding: 40px 20px 50px 20px;
            border-bottom-left-radius: 40px;
            border-bottom-right-radius: 40px;
            text-align: center;
            position: relative;
        }

        /* LOGO */
        .logo-container {
            margin-bottom: 15px;
        }

        .logo-container img {
            height: 60px;
            object-fit: contain;
        }

        .logo-placeholder {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            background: white;
            color: #0d6efd;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 22px;
            margin: auto;
        }

        /* SEARCH */
        .search-box {
            margin-top: -60px;
        }

        /* CATEGORY PILLS */
        .category-pill {
            border-radius: 50px;
            padding: 8px 20px;
        }

        /* CARD */
        .food-card {
            border: none;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
            transition: 0.3s ease;
            position: relative;
        }

        .food-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
        }

        .food-card img {
            height: 160px;
            object-fit: cover;
        }

        .price {
            color: #0d6efd;
            font-weight: 600;
        }

        .add-btn {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .badge-promo {
            position: absolute;
            top: 10px;
            left: 10px;
            background: #dc3545;
            font-size: 12px;
        }

        @media (max-width:576px) {
            .food-card img {
                height: 120px;
            }
        }

        /* Force toutes les cartes à avoir la même hauteur */
        .food-card {
            display: flex;
            flex-direction: column;
            height: 100%;
            /* Permet de remplir la hauteur de la colonne parent */
        }

        /* Body de la carte prend le reste de l'espace pour que l'image reste en haut */
        .food-card .card-body {
            flex: 1 1 auto;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            /* Permet de séparer titre et texte du bas si nécessaire */
        }
    </style>
</head>

<body>

    <div class="container py-2">

        <!-- HERO -->
        <div class="menu-hero mb-4">

            <!-- LOGO -->
            <div class="logo-container">

                <!-- OPTION 1 : Vrai logo -->

                <img src="{{ asset('templates/mazer/dist/assets/images/logo/logo.png') }}" alt="Logo">


                <!-- OPTION 2 : Placeholder
            <div class="logo-placeholder">
                LOGO
            </div>-->

            </div>

            <h2 class="fw-bold">Tout faire à distance</h2>
            <p>Bienvenu(e) dans notre service de dématérialisation de nos activités</p>
        </div>


        <!-- FOOD GRID -->
        <div class="row g-4">


            <div class="col-6 col-md-4 col-lg-3">
                <a href="{{ url('ies/index-validation') }}" class="card food-card text-decoration-none">
                    <img src="{{ asset('templates/mazer/dist/assets/images/demat/demande_validation.png') }}"
                        class="card-img-top">
                    <div class="card-body">
                        <h6 class="card-title text-capitalize text-dark">Effectuez une demande de rattachement à votre
                            maison de transit</h6>
                    </div>
                </a>
            </div>

            <div class="col-6 col-md-4 col-lg-3">
                <a href="{{ url('https://ies.aglgroup.com/dkrp/login') }}" class="card food-card text-decoration-none">
                    <img src="{{ asset('templates/mazer/dist/assets/images/demat/facturation.png') }}"
                        class="card-img-top">
                    <div class="card-body">
                        <h6 class="card-title text-capitalize text-dark">Générez vos factures proforma et factures
                            définitives</h6>
                    </div>
                </a>
            </div>

            <div class="col-6 col-md-4 col-lg-3">
                <a href="{{ url('#') }}" class="card food-card text-decoration-none">
                    <img src="{{ asset('templates/mazer/dist/assets/images/demat/paiement.png') }}"
                        class="card-img-top">
                    <div class="card-body">
                        <h6 class="card-title text-capitalize text-dark">Payez vos factures via les opérateurs Wave /
                            Yass / Orange Money</h6>
                    </div>
                </a>
            </div>

            <div class="col-6 col-md-4 col-lg-3">
                <a href="{{ url('ies/index-remise') }}" class="card food-card text-decoration-none">
                    <img src="{{ asset('templates/mazer/dist/assets/images/demat/demande_remise.png') }}"
                        class="card-img-top">
                    <div class="card-body">
                        <h6 class="card-title text-capitalize text-dark">Effectuez une demande de remise et recevez une
                            réduction</h6>
                    </div>
                </a>
            </div>


        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
