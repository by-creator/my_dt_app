<?php

use App\Http\Controllers\BadController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FactureController;
use App\Http\Controllers\ProformaController;
use App\Http\Controllers\RoleController;
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


    Route::post('/proforma', [ProformaController::class, 'store'])->name('proforma.store');
    Route::get('/proforma/view/{id}', [ProformaController::class, 'view'])->name('proforma.view');
    Route::get('/proforma/download/{id}', [ProformaController::class, 'download'])->name('proforma.download');
    Route::put('/proformas/{proforma}', [ProformaController::class, 'update'])->name('proformas.update');


    Route::post('/facture', [FactureController::class, 'store'])->name('facture.store');
    Route::get('/facture/view/{id}', [FactureController::class, 'view'])->name('facture.view');
    Route::get('/facture/download/{id}', [FactureController::class, 'download'])->name('facture.download');
    Route::put('/factures/{facture}', [FactureController::class, 'update'])->name('factures.update');

    Route::post('/bad', [BadController::class, 'store'])->name('bad.store');
    Route::get('/bad/view/{id}', [BadController::class, 'view'])->name('bad.view');
    Route::get('/bad/download/{id}', [BadController::class, 'download'])->name('bad.download');
    Route::put('/bads/{bad}', [BadController::class, 'update'])->name('bads.update');
});
