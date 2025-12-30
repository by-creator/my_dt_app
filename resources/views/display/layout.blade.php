<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Affichage – Dakar Terminal</title>

    {{-- Refresh --}}
    <meta http-equiv="refresh" content="10">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f4f7fb;
            font-family: "Segoe UI", sans-serif;
        }

        /* Sidebar */
        .sidebar {
            width: 240px;
            min-height: 100vh;
            background: #ffffff;
            border-right: 1px solid #e5e5e5;
            padding: 20px;
        }

        .sidebar img {
            max-width: 160px;
            margin-bottom: 30px;
        }

        .sidebar a {
            display: block;
            margin: 15px 0;
            color: #1d3557;
            font-weight: 500;
            text-decoration: none;
        }

        /* Main content */
        .content {
            padding: 30px;
        }

        .card-main {
            background: #ffffff;
            border-radius: 12px;
            padding: 40px;
            text-align: center;
        }

        .guichet {
            font-size: 2rem;
            font-weight: 600;
            color: #1d3557;
        }

        .ticket {
            font-size: 4rem;
            font-weight: 800;
            color: #1d3557;
            margin-top: 10px;
        }

        .card-qr {
            background: #ffffff;
            border-radius: 12px;
            padding: 25px;
            height: 100%;
        }

        .card-qr h5 {
            font-weight: 600;
            margin-bottom: 20px;
        }

        .card-qr img {
            width: 120px;
        }
    </style>
</head>
<body>

<div class="d-flex">

    {{-- Content --}}
    <div class="content flex-fill">
        @yield('content')
    </div>
</div>

</body>
</html>
