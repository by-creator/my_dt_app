<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Tutoriel ouverture de compte') }}
    </h2>
</x-slot>
@include('layouts.back.sidebar')
<div id="main" class='layout-navbar'>
    @include('layouts.back.header')
    <div id="main-content">
        <section id="multiple-column-form">
            <div class="row match-height">
                @include('partials.unify.tutorial')
            </div>
        </section>
    </div>
</div>