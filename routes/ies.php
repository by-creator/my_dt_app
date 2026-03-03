<?php

use App\Http\Controllers\DematController;
use App\Http\Controllers\DossierFacturationController;
use App\Http\Controllers\IpakiExtranetServiceController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {

    Route::prefix('ies')->name('ies.')->controller(IpakiExtranetServiceController::class)->group(function () {

        Route::get('/validation', [IpakiExtranetServiceController::class, 'validation'])->name('validation');
        Route::get('/create', [IpakiExtranetServiceController::class, 'create'])->name('create');
        Route::get('/link', [IpakiExtranetServiceController::class, 'link'])->name('link');
        Route::get('/reset-password', [IpakiExtranetServiceController::class, 'resetPassword'])->name('reset-password');
        Route::post('/send-validation-account', [IpakiExtranetServiceController::class, 'sendValidationAccount'])->name('send-validation-account');
        Route::post('/send-create', [IpakiExtranetServiceController::class, 'sendCreate'])->name('send-create');
        Route::post('/send-link', [IpakiExtranetServiceController::class, 'sendLink'])->name('send-link');
        Route::post('/send-reset-password', [IpakiExtranetServiceController::class, 'sendResetPassword'])->name('send-reset-password');
    });
});

Route::get('/ies/dematerialisation', [IpakiExtranetServiceController::class, 'dematerialisation'])->name('ies.dematerialisation');

Route::get('ies/index-validation', [DematController::class, 'indexValidation'])->name('ies.validation-index');
Route::get('ies/index-remise', [DematController::class, 'indexRemise'])->name('ies.remise-index');
Route::post('/ies/remise', [DematController::class, 'remise'])->name('ies.remise');
