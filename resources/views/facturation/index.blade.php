@extends('partials.app')

@section('title', 'Dashboard')

@section('sidebar-menu')
    @auth
        @if (Auth::user()->role->name == 'ADMIN' ||
                Auth::user()->role->name == 'FACTURATION' ||
                Auth::user()->role->name == 'SUPER_U')
            @include('partials.facturation.menu_unify_form')
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
            @if (Auth::user()->role->name == 'ADMIN' ||
                    Auth::user()->role->name == 'FACTURATION' ||
                    Auth::user()->role->name == 'SUPER_U')
                @include('partials.facturation.form')
            @else
            @endif
        </div>
    </div>
@endsection
