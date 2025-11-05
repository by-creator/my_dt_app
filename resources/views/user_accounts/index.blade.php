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
                        <li class="sidebar-title">Menu</li>

                        @if(Auth::user()->role->name == "ADMIN" || Auth::user()->role->name == "SUPER_U")
                        @include('partials.user_account.menu_user_account')
                        @endif


                        <li class="sidebar-item">
                            <a href="{{ route('settings') }}" class='sidebar-link'>
                                <i class="fa-solid fa-gear"></i>
                                <span>Paramètres</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
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
                @include('partials.user_account.form')
                @include('partials.user_account.list')
                @endif
            </div>
        </div>
    </div>
    @include('partials.dashboard.script')
</body>

</html>