<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dakar-Terminal</title>

<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{asset('templates/mazer/dist/assets/css/bootstrap.css')}}">

<link rel="stylesheet" href="{{asset('templates/mazer/dist/assets/vendors/iconly/bold.css')}}">

<link rel="stylesheet" href="{{asset('templates/mazer/dist/assets/vendors/perfect-scrollbar/perfect-scrollbar.css')}}">
<link rel="stylesheet" href="{{asset('templates/mazer/dist/assets/vendors/bootstrap-icons/bootstrap-icons.css')}}">
<link rel="stylesheet" href="{{asset('templates/mazer/dist/assets/css/app.css')}}">

<link rel="icon" href="{{asset('templates/fiche/assets/img/logo.png')}}" >
<link rel="manifest" href="/manifest.json">
<link rel="apple-touch-icon" href="{{ asset('templates/fiche/assets/img/logo.png') }}">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-title" content="{{ config('app.name') }}">
<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">



<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="assets/css/bootstrap.css">

<link rel="stylesheet" href="{{asset('templates/mazer/dist/assets/vendors/simple-datatables/style.css')}}">

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<link rel="stylesheet" href="{{asset('templates/mazer/dist/assets/vendors/toastify/toastify.css')}}">
<link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet">
<link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet">

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">


  <style>

    /* Conteneur principal */
    .premium-card {
      background-color: white;
      border-radius: 20px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
      overflow: hidden;
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