<?php


use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DematController;
use App\Http\Controllers\IpakiExtranetServiceController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;



Route::get('/', fn () => view('index'))->name('home');

Route::post('/login', [LoginController::class, 'store'])
    ->middleware(['guest'])
    ->name('login.custom.store');

//Route::get('/demat', [DematController::class, 'index'])->name('demat.index');
// Route définie dans ies.php : Route::get('/ies/dematerialisation', ...)->name('ies.dematerialisation')
Route::get('/demat', [IpakiExtranetServiceController::class, 'dematerialisation']);



Route::post('/demat/send-validation', [IpakiExtranetServiceController::class, 'sendValidation'])->name('ies.send-validation');
Route::post('/demat/validation', [DematController::class, 'validation'])->name('demat.validation');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');

require __DIR__.'/auth.php';
require __DIR__.'/admin.php';
require __DIR__.'/inventaire.php';
require __DIR__.'/facturation.php';
require __DIR__.'/ipaki.php';
require __DIR__.'/unify.php';
require __DIR__.'/ies.php';
require __DIR__.'/ordre_approche.php';
require __DIR__.'/planification.php';
require __DIR__.'/rapport.php';
require __DIR__.'/informatique.php';
require __DIR__.'/gfa.php';
require __DIR__.'/douane.php';
require __DIR__.'/yard.php';
require __DIR__.'/file_attente.php';
