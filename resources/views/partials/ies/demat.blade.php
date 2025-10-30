<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dakar-Terminal</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <!-- Favicon standard -->
    <link href="{{asset('templates/fiche/assets/img/logo.png')}}" rel="icon">
    <!-- Pour Android -->
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <meta name="theme-color" content="#0d6efd">

    <!-- Pour iOS -->
    <link rel="apple-touch-icon" href="{{ asset('templates/fiche/assets/img/logo.png') }}">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-title" content="{{ config('app.name') }}">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">

  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(135deg, #f8f9fa, #e8ecf5);
      min-height: 100vh;
    }

    /* Barre de navigation */
    .navbar {
      background-color: white;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    }

    .navbar-brand img {
      height: 40px;
      margin-right: 10px;
    }

    /* Conteneur principal */
    .premium-card {
      background-color: white;
      border-radius: 20px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
      overflow: hidden;
    }

    /* Onglets */
    .nav-tabs .nav-link {
      border: none;
      border-radius: 10px 10px 0 0;
      color: #555;
      font-weight: 600;
      transition: all 0.3s ease;
    }

    .nav-tabs .nav-link.active {
      background-color: #0d6efd;
      color: white;
    }

    .tab-pane {
      padding: 2rem;
      animation: fadeIn 0.6s ease;
    }

    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: translateY(10px);
      }

      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    /* Boutons personnalisés */
    .btn-gradient {
      background: linear-gradient(45deg, #0d6efd, #6610f2);
      border: none;
      color: white;
      font-weight: 600;
      transition: all 0.3s ease;
    }

    .btn-gradient:hover {
      opacity: 0.9;
      transform: scale(1.02);
    }

    footer {
      text-align: center;
      margin-top: 50px;
      color: #888;
    }
  </style>
</head>

<body>

  <!-- Navbar avec logo -->
  <nav class="navbar navbar-expand-lg sticky-top">
    <div class="container">
      <a class="navbar-brand d-flex align-items-center" href="#">
        <img src="{{asset('templates/site/images/logo.png')}}" alt="Logo">
        <span class="fw-bold">DAKAR-TERMINAL</span>
      </a>
    </div>
  </nav>

  <!-- Section principale -->
  <div class="container py-5">
    <div class="premium-card mx-auto" style="max-width: 900px;">
      <ul class="nav nav-tabs justify-content-center p-3" id="premiumTabs" role="tablist">
        <li class="nav-item"><button class="nav-link active" data-bs-toggle="tab" data-bs-target="#home" type="button">VALIDER</button></li>
        <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#profil" type="button">FACTURER</button></li>
        <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#contact" type="button">PAYER</button></li>
      </ul>

      <div class="tab-content">
        <!-- Accueil -->
        <div class="text-center tab-pane fade show active" id="home">
          <img src="{{asset('templates/site/images/hero_10.png')}}" class="img-fluid rounded mb-3" alt="Accueil">
          <h3><u>VALIDATION</u></h3>
          <p>Veuillez remplir le formulaire ci-dessous pour demander la validation de votre dossier.</p>
          <form method="post" action="{{route('ies.send-validation')}}" class="form" enctype="multipart/form-data">
            @csrf
            @if (session('sendValidation'))
            <script>
              Swal.fire({
                icon: 'success',
                title: 'Demande de validation envoyée ✅',
                text: "{{ session('sendValidation') }}",
                showConfirmButton: true
              });
            </script>
            @endif
            <div class="mb-3">
              <input type="text" name="nom" class="text-center form-control" required placeholder="Nom du transitaire (ex : THIAW)">
            </div>
            <div class="mb-3">
              <input type="text" name="prenom" class="text-center form-control" required placeholder="Prénom du transitaire (ex : Moussa)">
            </div>
            <div class="mb-3">
              <input type="email" name="email" class="text-center form-control" required placeholder="Adresse mail du transitaire (ex : mail@gmail.com)">
            </div>
            <div class="mb-3">
              <input type="text" name="bl" class="text-center form-control" required placeholder="Numéro de BL (ex : S320...)">
            </div>
            <div class="mb-3">
              <input type="text" name="compte" class="text-center form-control" required placeholder="Numéro de compte société (ex : SN../ND../1234)">
            </div>
             <div class="mb-3">
              <input type="file" name="documents[]" multiple class="text-center form-control" required >
            </div>
            <button class="btn btn-gradient w-100">VALIDATION</button>
          </form>
        </div>

        <!-- Profil -->
        <div class="text-center tab-pane fade" id="profil">
          <img src="{{asset('templates/site/images/hero_8.png')}}" class="img-fluid rounded mb-3" alt="Profil">
          <h3><u>FACTURATION</u></h3>
          <p>Afin d'accéder à la plateforme de facturation cliqez sur le bouton ci-dessous : </p>
          <form>
            <a href="https://ies.aglgroup.com/dkrp/Login" class="btn btn-gradient w-100">FACTURATION</a>
          </form>
        </div>

        <!-- Contact -->
        <div class="text-center tab-pane fade" id="contact">
          <img src="{{asset('templates/site/images/hero_9.png')}}" class="img-fluid rounded mb-3" alt="Contact">
          <h3><u>PAIEMENT</u></h3>
          <p>Afin d'accéder à la plateforme de paiement cliqez sur le bouton ci-dessous : </p>
          <a href="https://mytouchpoint.net/dakar_terminal" class="btn btn-gradient w-100">PAIEMENT</a>
          </form>
        </div>
      </div>
    </div>
  </div>

  <footer>
    <p>© 2025 Dakar-Terminal — Tous droits réservés</p>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>