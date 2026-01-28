<?php

use App\Http\Controllers\RapportController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {

    Route::prefix('rapport')->name('rapport.')->controller(RapportController::class)->group(function () {
        Route::get('/index', [RapportController::class, 'index'])->name('index');
        Route::post('/infos_facturation/import', [RapportController::class, 'infosFacturationImport'])->name('infos_facturation.import');
    });
});
