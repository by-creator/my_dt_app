@extends('partials.app')

@section('title', 'Dashboard')

@section('sidebar-menu')
    @auth
        @if (
            $user->role->name == 'ADMIN' ||
                $user->role->name == 'SUPER_U' ||
                $user->role->name == 'OPERATIONS' ||
                $user->role->name == 'QHSE')
            @include('partials.ordre_approche.menu')
        @endif
    @endauth

@endsection

@section('content')
    <div id="main">
        <div class="page-content">
                @if (
                    $user->role->name == 'ADMIN' ||
                        $user->role->name == 'SUPER_U' ||
                        $user->role->name == 'OPERATIONS' ||
                        $user->role->name == 'QHSE')
                    @include('partials.ordre_approche.list')
                @endif
            </div>
    </div>
@endsection
