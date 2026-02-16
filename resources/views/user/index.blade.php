@extends('partials.app')

@section('title', 'Dashboard')

@section('sidebar-menu')
    @auth
        @if (Auth::user()->role->name == 'ADMIN')
            @include('partials.dashboard.admin.user.menu_user')
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
            @if (Auth::user()->role->name == 'ADMIN')
                @include('partials.dashboard.admin.user.form_user')
                @include('partials.dashboard.admin.user.list_user')
            @endif
        </div>
    </div>
@endsection
