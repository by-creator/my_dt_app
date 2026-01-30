<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Agent</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f5f8fd;
            font-family: "Segoe UI", sans-serif;
        }
        .card-main {
            border-radius: 14px;
            padding: 40px;
            text-align: center;
        }
        .ticket {
            font-size: 3rem;
            font-weight: 800;
        }
        .btn-action {
            width: 100%;
            padding: 15px;
            font-weight: 600;
        }
    </style>
</head>
<body>

<div class="container-fluid p-4">
    @yield('content')
</div>

</body>
</html>
