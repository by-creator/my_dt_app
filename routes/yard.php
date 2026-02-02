<?php

use App\Http\Controllers\YardController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {

    Route::prefix('yard')->name('yard.')->controller(YardController::class)->group(function () {

        Route::post('/import', [YardController::class, 'import'])->name('import');
    });
});
