<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dakar-Terminal</title>

<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('templates/mazer/dist/assets/css/bootstrap.css') }}">

<link rel="stylesheet" href="{{ asset('templates/mazer/dist/assets/vendors/iconly/bold.css') }}">

<link rel="stylesheet"
    href="{{ asset('templates/mazer/dist/assets/vendors/perfect-scrollbar/perfect-scrollbar.css') }}">
<link rel="stylesheet" href="{{ asset('templates/mazer/dist/assets/vendors/bootstrap-icons/bootstrap-icons.css') }}">
<link rel="stylesheet" href="{{ asset('templates/mazer/dist/assets/css/app.css') }}">

<link rel="icon" href="{{ asset('templates/fiche/assets/img/logo.png') }}">
<link rel="manifest" href="/manifest.json">
<link rel="apple-touch-icon" href="{{ asset('templates/fiche/assets/img/logo.png') }}">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-title" content="{{ config('app.name') }}">
<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">



<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="assets/css/bootstrap.css">

<link rel="stylesheet" href="{{ asset('templates/mazer/dist/assets/vendors/simple-datatables/style.css') }}">

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<link rel="stylesheet" href="{{ asset('templates/mazer/dist/assets/vendors/toastify/toastify.css') }}">
<link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet">
<link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet">

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">



<style>
    body {
        background: #f6f8fc;
    }

    .card-hover {
        background: rgba(255, 255, 255, 0.75);
        backdrop-filter: blur(10px);
        border-radius: 20px;
        transition: 0.4s ease;
        border: 1px solid rgba(255, 255, 255, .5);
    }

    .card-hover:hover {
        transform: translateY(-12px) scale(1.03);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
    }

    .folder-icon {
        width: 90px;
        height: 90px;
        border-radius: 50%;
        background: linear-gradient(135deg, #0d6efd, #6610f2);
        display: flex;
        justify-content: center;
        align-items: center;
        margin: auto;
        box-shadow: 0 10px 25px rgba(13, 110, 253, 0.4);
    }

    .folder-icon i {
        font-size: 38px;
        color: white;
    }

    .badge-bl {
        background: rgba(13, 110, 253, 0.07);
        border: 1px dashed #0d6efd;
        color: #0d6efd;
        font-size: 13px;
        padding: 10px 16px;
        border-radius: 50px;
    }

    .btn-modern {
        background: linear-gradient(135deg, #0d6efd, #6610f2);
        border: none;
        color: white;
        font-weight: bold;
        padding: 8px 22px;
        border-radius: 50px;
        transition: 0.3s;
    }

    .btn-modern:hover {
        transform: scale(1.05);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
    }

    .doc-card {
        background: rgba(255, 255, 255, 0.75);
        backdrop-filter: blur(12px);
        border-radius: 24px;
        border: 1px solid rgba(255, 255, 255, 0.4);
        transition: 0.4s ease;
    }

    .doc-card:hover {
        transform: translateY(-10px) scale(1.02);
        box-shadow: 0 20px 50px rgba(0, 0, 0, 0.15);
    }

    .doc-header {
        background: transparent !important;
        border-bottom: none;
        padding: 0;
    }

    .doc-title {
        font-weight: bold;
        font-size: 18px;
    }

    .doc-count {
        background: linear-gradient(135deg, #0d6efd, #6610f2);
        color: white;
        padding: 6px 14px;
        border-radius: 40px;
        font-size: 13px;
        box-shadow: 0 8px 15px rgba(13, 110, 253, 0.4);
    }

    .file-item {
        background: rgba(255, 255, 255, 0.8);
        border-radius: 16px;
        padding: 10px 15px;
        margin-bottom: 10px;
        border: 1px solid rgba(0, 0, 0, .03);
    }

    .file-item span {
        max-width: 140px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        display: inline-block;
    }

    .file-btn {
        border-radius: 50%;
        width: 33px;
        height: 33px;
        padding: 0;
        display: inline-flex;
        justify-content: center;
        align-items: center;
    }

    .generate-btn {
        background: linear-gradient(135deg, #0d6efd, #6610f2);
        border: none;
        color: white;
        border-radius: 40px;
        padding: 6px 15px;
    }

    .relance-btn {
        background: linear-gradient(135deg, #ff9f1c, #f76c6c);
        border: none;
        color: white;
        border-radius: 50px;
        font-weight: 600;
    }
</style>


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
