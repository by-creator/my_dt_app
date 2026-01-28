<?php

use App\Http\Controllers\PlanificationController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {

    Route::prefix('planification')->name('planification.')->controller(PlanificationController::class)->group(function () {

        Route::get('/index', [PlanificationController::class, 'index'])->name('index');
        Route::post('/import', [PlanificationController::class, 'import'])->name('import');
    });
});
