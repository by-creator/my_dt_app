
@extends('partials.app')

@section('title', 'Dashboard')

@section('sidebar-menu')
    @auth
       @if(Auth::user()->role->name == "ADMIN" || Auth::user()->role->name == "SUPER_U" || Auth::user()->role->name == "FACTURATION")
                        @include('partials.facturation.menu_facturation')
                        @else
                        @endif
    @endauth

@endsection
@section('content')
    <div id="main">
        <header class="mb-3">
            <a href="#" class="burger-btn d-block d-xl-none">
                <i class="bi bi-justify fs-3"></i>
            </a>
        </header>

        <div class="page-heading">
            <h3>Bienvenu(e) {{ $user->name }} </h3>
        </div>
       <div class="page-content">
                @if(Auth::user()->role->name == "ADMIN" || Auth::user()->role->name == "SUPER_U" || Auth::user()->role->name == "FACTURATION")
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
                <form method="post" action="{{route('ies.send-create')}}" class="form" enctype="multipart/form-data">
                    @csrf
                    <div class="row match-height">
                        @include('partials.ies.form_create')
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="col-12 d-flex justify-content-center">
                                        <button type="submit" name="submit" class="btn btn-primary me-1 mb-1">Envoyer</button>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                @else
                @endif
            </div>
    </div>
@endsection
