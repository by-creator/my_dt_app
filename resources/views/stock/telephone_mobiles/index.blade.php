@extends('partials.app')

@section('title', 'Dashboard')

@section('sidebar-menu')
    @auth
    @if(auth()->user()->role->name === "ADMIN")
        @include('partials.stock.menu_stock')
    @elseif(auth()->user()->role->name === "USER")
        @include('partials.user.menu')
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
                @if($user->role->name == "ADMIN")
                @include('partials.stock.telephone_mobiles.form')
                @include('partials.stock.telephone_mobiles.list')
                @endif
            </div>
        </div>
@endsection
