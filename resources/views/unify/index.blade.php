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
                <a href="index.html"><img src="{{asset('templates/mazer/dist/assets/images/logo/logo.png')}}" alt="Logo" srcset=""></a>
                <div class="sidebar-menu">
                    <ul class="menu">
                        <li class="sidebar-title">Menu</li>

                        @if(Auth::user()->role_id === 1)
                        @include('partials.unify.menu_unify')
                        @else
                        @endif


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
                <form method="post" action="{{route('unify.add')}}" class="form" enctype="multipart/form-data">
                    @csrf
                    <script>
                        Swal.fire({
                            icon: 'success',
                            title: 'Création de compte',
                            text: "{{ session('sendTiers') }}",
                            showConfirmButton: true
                        });
                    </script>

                    @if(Auth::user()->role_id === 1 || Auth::user()->role_id === 2)
                    @include('partials.unify.unify_infos')
                    @include('partials.unify.personal_infos')
                    @include('partials.unify.society_infos')
                    @else
                    @endif
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="col-12 d-flex justify-content-center">
                                    <button type="submit" name="submit" value="fiche" class="btn btn-primary me-1 mb-1">Imprimer Fiche </button>
                                    <button type="submit" name="submit" value="attestation" class="btn btn-primary me-1 mb-1">Imprimer Attestation </button>
                                    <button type="submit" name="submit" value="sendTiers" class="btn btn-primary me-1 mb-1">Envoyer le tiers</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>



            <footer>
                <div class="footer clearfix mb-0 text-muted">
                    <div class="float-start">
                        <p>2021 &copy; Mazer</p>
                    </div>
                    <div class="float-end">
                        <p>Crafted with <span class="text-danger"><i class="bi bi-heart"></i></span> by <a
                                href="http://ahmadsaugi.com">A. Saugi</a></p>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    @include('partials.dashboard.script')
</body>

</html>