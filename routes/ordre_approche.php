<?php

use App\Http\Controllers\OrdreApprocheController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {

    Route::prefix('ordre_approche')->name('ordre_approche.')->controller(OrdreApprocheController::class)->group(function () {

        Route::get('/index', [OrdreApprocheController::class, 'index'])->name('index');
        Route::post('/list', [OrdreApprocheController::class, 'list'])->name('list');
        Route::post('/create', [OrdreApprocheController::class, 'create'])->name('create');
        Route::post('/update/{id}', [OrdreApprocheController::class, 'update'])->name('update');
        Route::delete('/delete/{id}', [OrdreApprocheController::class, 'delete'])->name('delete');
        Route::post('/import', [OrdreApprocheController::class, 'import'])->name('import');
        Route::get('/datalist', 'datalist')->name('datalist');
    });
});
