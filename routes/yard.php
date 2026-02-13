<?php

use App\Http\Controllers\YardController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {

    Route::prefix('yard')->name('yard.')->controller(YardController::class)->group(function () {

        Route::get('/index', [YardController::class, 'index'])->name('index');
        Route::post('/list', [YardController::class, 'list'])->name('list');
        Route::post('/import', [YardController::class, 'import'])->name('import');
        Route::get('/datalist', [YardController::class, 'datalist'])->name('datalist');
    });
});
