<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire de validation</title>

    <!-- Bootstrap 5 CSS (optionnel mais pratique pour responsive) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- SweetAlert2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.8.20/dist/sweetalert2.min.css" rel="stylesheet">

    <style>
        /* Corps de page */
        body {
            background: #f4f7fb;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #333;
        }

        /* Container principale */
        .premium-card {
            background: #fff;
            border-radius: 20px;
            padding: 40px 30px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.05);
            max-width: 900px;
            margin: 50px auto;
        }

        /* Image hero */
        .premium-card img {
            max-height: 250px;
            object-fit: cover;
            margin-bottom: 20px;
            border-radius: 12px;
        }

        /* Titres */
        .premium-card h3 {
            margin-bottom: 20px;
            color: #0d6efd;
            text-align: center;
        }

        /* Formulaire */
        .premium-card .form-control {
            border-radius: 12px;
            padding: 10px 15px;
            font-size: 14px;
            margin-bottom: 15px;
        }

        /* Inputs centrés */
        .premium-card .form-control.text-center {
            text-align: center;
        }

        /* Bouton gradient */
        .btn-gradient {
            background: linear-gradient(135deg,#0d6efd,#3d8bfd);
            border: none;
            color: white;
            font-weight: 600;
            padding: 12px;
            border-radius: 12px;
            transition: 0.3s ease;
            width: 100%;
        }

        .btn-gradient:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.15);
        }

        /* Labels */
        .premium-card label {
            font-weight: 600;
            margin-bottom: 5px;
            display: block;
        }

        /* Footer */
        footer {
            text-align: center;
            padding: 20px;
            margin-top: 50px;
            font-size: 14px;
            color: #555;
        }

        /* Responsive cards */
        @media(max-width:768px){
            .premium-card {
                padding: 30px 20px;
                margin: 30px 15px;
            }
        }
    </style>
</head>
<body>

<div class="premium-card">
    <h3>Formulaire de validation</h3>

    <!-- Image hero -->
    <img src="{{asset('templates/site/images/hero_12.jpeg')}}" alt="Image hero" class="img-fluid">

    <!-- Formulaire -->
    <form id="validationForm" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="nom">Nom</label>
            <input type="text" class="form-control text-center" id="nom" name="nom" placeholder="Votre nom" required>
        </div>

        <div class="mb-3">
            <label for="prenom">Prénom</label>
            <input type="text" class="form-control text-center" id="prenom" name="prenom" placeholder="Votre prénom" required>
        </div>

        <div class="mb-3">
            <label for="email">Email</label>
            <input type="email" class="form-control text-center" id="email" name="email" placeholder="Votre email" required>
        </div>

        <div class="mb-3">
            <label for="fichier">Fichier à joindre</label>
            <input type="file" class="form-control" id="fichier" name="fichier" required>
        </div>

        <button type="submit" class="btn btn-gradient">ENVOYER LA DEMANDE DE VALIDATION</button>
    </form>
</div>

<footer>
    &copy; 2026 MonSite. Tous droits réservés.
</footer>

<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.8.20/dist/sweetalert2.all.min.js"></script>

<script>
    // SweetAlert avant soumission
    const form = document.getElementById('validationForm');
    form.addEventListener('submit', function(e){
        e.preventDefault(); // Empêche envoi direct

        Swal.fire({
            title: 'Confirmer l’envoi',
            text: "Voulez-vous envoyer cette demande de validation ?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Oui, envoyer',
            cancelButtonText: 'Annuler',
            reverseButtons: true
        }).then((result) => {
            if(result.isConfirmed){
                form.submit(); // Soumission réelle
            }
        });
    });
</script>

</body>
</html>