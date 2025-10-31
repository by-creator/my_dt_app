<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\IpakiController;
use App\Http\Controllers\IpakiExtranetServiceController;
use App\Http\Controllers\OrdinateurController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TelephoneFixeController;
use App\Http\Controllers\UnifyController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return view('index');
})->name('home');

Route::get('/demat', function () {
    return view('demat');
})->name('demat');

Route::get('/register', function () {
    return view('livewire.auth.login');
})->name('register');

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


    Route::get('/ies/demat', [IpakiExtranetServiceController::class, 'demat'])->name('ies.demat');

    Route::get('/ies/create', [IpakiExtranetServiceController::class, 'create'])->name('ies.create');
    Route::get('/ies/link', [IpakiExtranetServiceController::class, 'link'])->name('ies.link');
    Route::get('/ies/reset-password', [IpakiExtranetServiceController::class, 'resetPassword'])->name('ies.reset-password');
    Route::post('/ies/send-create', [IpakiExtranetServiceController::class, 'sendCreate'])->name('ies.send-create');
    Route::post('/ies/send-link', [IpakiExtranetServiceController::class, 'sendLink'])->name('ies.send-link');
    Route::post('/ies/send-validation', [IpakiExtranetServiceController::class, 'sendValidation'])->name('ies.send-validation');
    Route::post('/ies/send-reset-password', [IpakiExtranetServiceController::class, 'sendResetPassword'])->name('ies.send-reset-password');

    Route::get('/ordinateur/index', [OrdinateurController::class, 'index'])->name('ordinateur.index');
    Route::post('/ordinateur/create', [OrdinateurController::class, 'create'])->name('ordinateur.create');
    Route::put('/ordinateur/update/{id}', [OrdinateurController::class, 'update'])->name('ordinateur.update');
    Route::delete('/ordinateur/delete/{id}', [OrdinateurController::class, 'delete'])->name('ordinateur.delete');
    Route::post('/ordinateur/import', [OrdinateurController::class, 'import'])->name('ordinateur.import');
    Route::get('/ordinateur/export', [OrdinateurController::class, 'export'])->name('ordinateur.export');

    Route::get('/telephone-fixe', [TelephoneFixeController::class, 'index'])->name('telephone-fixe.index');
    Route::post('/telephone-fixe/create', [TelephoneFixeController::class, 'create'])->name('telephone-fixe.create');
    Route::put('/telephone-fixe/update/{id}', [TelephoneFixeController::class, 'update'])->name('telephone-fixe.update');
    Route::delete('/telephone-fixe/delete/{id}', [TelephoneFixeController::class, 'delete'])->name('telephone-fixe.delete');
    Route::post('/telephone-fixe/import', [TelephoneFixeController::class, 'import'])->name('telephone-fixe.import');
    Route::get('/telephone-fixe/export', [TelephoneFixeController::class, 'export'])->name('telephone-fixe.export');
    Route::get('/telephone-fixe/tutorial', [TelephoneFixeController::class, 'tutorial'])->name('telephone-fixe.tutorial');
});
