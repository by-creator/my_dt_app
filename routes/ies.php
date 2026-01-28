<?php

use App\Http\Controllers\IpakiExtranetServiceController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {

Route::prefix('ies')->name('ies.')->controller(IpakiExtranetServiceController::class)->group(function (){
   
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