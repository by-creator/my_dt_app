@extends('partials.app')

@section('content')
<div id="app">

    <div id="main">
        <header class="mb-3">
            <a href="#" class="burger-btn d-block d-xl-none">
                <i class="bi bi-justify fs-3"></i>
            </a>
        </header>

        <div class="page-heading">
            <a href="{{ route('dashboard') }}"><img src="{{asset('templates/mazer/dist/assets/images/logo/logo.png')}}" alt="Logo" srcset=""></a>
            <br>
            <br>
            <h3>Bienvenu(e) {{ Auth::user()->name }}</h3>
        </div>
        <div class="page-content">
            @if(Auth::user()->role->name == "CLIENT_FACTURATION" || Auth::user()->role->name == "ADMIN" || Auth::user()->role->name == "SUPER_U")
            @include('partials.dossier_facturation.paiement')
            @endif
        </div>
    </div>
</div>
@endsection