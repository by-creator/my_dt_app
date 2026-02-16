<!DOCTYPE html>
<html data-bs-theme="light" class="light">

<head>
    @include('partials.dashboard.head')
</head>

<body>

    <nav>
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
                <a href="{{ route('dashboard') }}"><img
                        src="{{ asset('templates/mazer/dist/assets/images/logo/logo.png') }}" width="300"
                        alt="Logo" srcset=""></a>
                <div class="sidebar-menu">
                    <ul class="menu">

                        <li class="sidebar-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                            <a href="{{ route('dashboard') }}" class="sidebar-link">
                                <i class="fa-solid fa-home"></i>
                                <span>Accueil</span>
                            </a>
                        </li>
                        @if (Auth::user()->role->name == 'CLIENT_FACTURATION')
                            @include('partials.dossier_facturation.menu')
                        @else
                        @endif
                        @yield('sidebar-menu')
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
    </nav>

    <main class="py-2">
       
        @yield('content')
    </main>
    @include('partials.dashboard.script')
    @stack('scripts')



</body>

</html>
