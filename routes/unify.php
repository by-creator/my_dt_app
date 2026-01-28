<?php

use App\Http\Controllers\UnifyController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {

    Route::prefix('unify')->name('unify.')->controller(UnifyController::class)->group(function () {
        Route::get('/unify', [UnifyController::class, 'index'])->name('index');
        Route::get('/unify/create', [UnifyController::class, 'create'])->name('create');
        Route::get('/unify/tutorial', [UnifyController::class, 'tutorial'])->name('tutorial');
        Route::post('/unify/add', [UnifyController::class, 'add'])->name('add');
    });
});
