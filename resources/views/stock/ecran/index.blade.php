<!DOCTYPE html>
<html lang="en">

<head>
    @include('partials.dashboard.head')
</head>

<body>
    <div id="app">
        <div id="sidebar" class="active">
            <div class="sidebar-wrapper active">
                <div class="sidebar-header">
                    <div class="d-flex justify-content-between">
                        <div>
                        </div>
                        <div class="toggler">
                            <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
                        </div>
                    </div>
                </div>
                <a href="{{ route('dashboard') }}"><img src="{{asset('templates/mazer/dist/assets/images/logo/logo.png')}}" alt="Logo" srcset=""></a>
                <div class="sidebar-menu">
                    <ul class="menu">
                       
                        <li class="sidebar-title">
                        <a href="{{ route('dashboard') }}">
                            <i class="fa-solid fa-home"></i>
                            <span>Accueil</span>
                        </a>
                    </li>

                        @if(Auth::user()->role->name == "ADMIN" || Auth::user()->role->name == "SUPER_U")
                        @include('partials.stock.menu_stock')
                        @else
                        @endif
                        
                        <li class="sidebar-item">
                            <a href="{{ route('settings') }}" class='sidebar-link'>
                                <i class="fa-solid fa-gear"></i>
                                <span>Paramètres</span>
                            </a>
                        </li>
                       
                        <li class="sidebar-item  ">
                            <a href="{{ route('dashboard.logout') }}" class='sidebar-link'>
                                <i class="fa-solid fa-right-from-bracket"></i>
                                <span>Déconnexion</span>
                            </a>
                        </li>

                    </ul>
                </div>
                <button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
            </div>
        </div>
        <div id="main">
            <header class="mb-3">
                <a href="#" class="burger-btn d-block d-xl-none">
                    <i class="bi bi-justify fs-3"></i>
                </a>
            </header>

            <div class="page-heading">
                <h3>Bienvenu(e) {{ Auth::user()->name }}</h3>
            </div>
            <div class="page-content">
                @if(Auth::user()->role->name == "ADMIN" || Auth::user()->role->name == "SUPER_U")
                @if (session('create'))
                <script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Création de compte',
                        text: "{{ session('create') }}",
                        showConfirmButton: true
                    });
                </script>
                @endif
                <form method="post" action="{{route('ecran.create')}}" class="form" enctype="multipart/form-data">
                    @csrf
                    <div class="row match-height">
                        @include('partials.stock.ecran.form')
                        @include('partials.stock.ecran.list')
                    </div>
                </form>
                @else
                @endif
            </div>
        </div>
    </div>
    @include('partials.dashboard.script')
</body>

</html>