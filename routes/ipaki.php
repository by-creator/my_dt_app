<?php

use App\Http\Controllers\IpakiController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {

    Route::prefix('ipaki')->name('ipaki.')->controller(IpakiController::class)->group(function () {

        Route::get('/admin', [IpakiController::class, 'admin'])->name('admin');
        Route::get('/list', [IpakiController::class, 'list'])->name('list');
        Route::put('/update/{id}', [IpakiController::class, 'update'])->name('update');
        Route::delete('/delete/{id}', [IpakiController::class, 'delete'])->name('delete');
        Route::post('/import', [IpakiController::class, 'import'])->name('import');
        Route::get('/export', [IpakiController::class, 'export'])->name('export');
        Route::get('/truncate', [IpakiController::class, 'truncate'])->name('truncate');
        Route::post('/filter', [IpakiController::class, 'filter'])->name('filter');
        Route::post('/form', [IpakiController::class, 'form'])->name('form');
        Route::post('/create', [IpakiController::class, 'create'])->name('create');
    });
});
