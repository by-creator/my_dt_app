<?php

use App\Http\Controllers\BadController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FactureController;
use App\Http\Controllers\IpakiController;
use App\Http\Controllers\ProformaController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UnifyController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('dashboard', [RoleController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile')->name('settings');

    Volt::route('settings/profile', 'settings.profile')->name('profile.edit');
    Volt::route('settings/password', 'settings.password')->name('user-password.edit');
    Volt::route('settings/appearance', 'settings.appearance')->name('appearance.edit');

    Volt::route('settings/two-factor', 'settings.two-factor')
        ->middleware(
            when(
                Features::canManageTwoFactorAuthentication()
                    && Features::optionEnabled(Features::twoFactorAuthentication(), 'confirmPassword'),
                ['password.confirm'],
                [],
            ),
        )
        ->name('two-factor.show');

    Route::get('/dashboard/logout', [DashboardController::class, 'logout'])->name('dashboard.logout');

    Route::get('/role', [RoleController::class, 'index'])->name('role.index');

    Route::post('/role/create', [RoleController::class, 'create'])->name('role.create');
    Route::put('/role/update/{id}', [RoleController::class, 'update'])->name('role.update');
    Route::delete('/role/delete/{id}', [RoleController::class, 'delete'])->name('role.delete');
    Route::post('/role/import', [RoleController::class, 'import'])->name('role.import');
    Route::get('/role/export', [RoleController::class, 'export'])->name('role.export');


    Route::get('/user', [UserController::class, 'index'])->name('user.index');

    Route::post('/user/create', [UserController::class, 'create'])->name('user.create');
    Route::put('/user/update/{id}', [UserController::class, 'update'])->name('user.update');
    Route::delete('/user/delete/{id}', [UserController::class, 'delete'])->name('user.delete');
    Route::post('/user/import', [UserController::class, 'import'])->name('user.import');
    Route::get('/user/export', [UserController::class, 'export'])->name('user.export');


    Route::get('/unify', [UnifyController::class, 'index'])->name('unify.index');
    Route::get('/unify/create', [UnifyController::class, 'create'])->name('unify.create');
    Route::get('/unify/tutorial', [UnifyController::class, 'tutorial'])->name('unify.tutorial');
    Route::post('/unify/add', [UnifyController::class, 'add'])->name('unify.add');



    Route::get('/ipaki/admin', [IpakiController::class, 'admin'])->name('ipaki.admin');
    Route::get('/ipaki/list', [IpakiController::class, 'list'])->name('ipaki.list');
    Route::put('/ipaki/update/{id}', [IpakiController::class, 'update'])->name('ipaki.update');
    Route::delete('/ipaki/delete/{id}', [IpakiController::class, 'delete'])->name('ipaki.delete');
    Route::post('/ipaki/import', [IpakiController::class, 'import'])->name('ipaki.import');
    Route::get('/ipaki/export', [IpakiController::class, 'export'])->name('ipaki.export');
    Route::get('/ipaki/truncate', [IpakiController::class, 'truncate'])->name('ipaki.truncate');
    Route::post('/ipaki/filter', [IpakiController::class, 'filter'])->name('ipaki.filter');
    Route::post('/ipaki/form', [IpakiController::class, 'form'])->name('ipaki.form');
    Route::post('/ipaki/create', [IpakiController::class, 'create'])->name('ipaki.create');
});
