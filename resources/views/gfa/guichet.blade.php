@extends('partials.app')

@push('head')
    <meta http-equiv="refresh" content="10">
@endpush

@section('content')
<div id="app">
    <div id="main">
        <header class="mb-3">
            <a href="#" class="burger-btn d-block d-xl-none">
                <i class="bi bi-justify fs-3"></i>
            </a>
        </header>

        <div class="page-heading">
            <h3>Bienvenu(e) {{ $user->name }} </h3>
            @include('partials.gfa.agent.dashboard')
        </div>
    </div>
</div>
@endsection
