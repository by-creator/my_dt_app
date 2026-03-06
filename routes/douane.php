<?php

use App\Http\Controllers\DouaneController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {

    Route::prefix('douane')->name('douane.')->controller(DouaneController::class)->group(function () {

        Route::get('/index', [DouaneController::class, 'index'])->name('index');
    });
});
