<?php

use App\Http\Controllers\UserAccountController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {

     Route::get('/user-accounts', [UserAccountController::class, 'index'])->name('user_accounts.index');

    Route::post('/user-accounts/create', [UserAccountController::class, 'create'])->name('user_accounts.create');
    Route::put('/user-accounts/update/{id}', [UserAccountController::class, 'update'])->name('user_accounts.update');
    Route::delete('/user-accounts/delete/{id}', [UserAccountController::class, 'delete'])->name('user_accounts.delete');
    Route::post('/user-accounts/import', [UserAccountController::class, 'import'])->name('user_accounts.import');
    Route::get('/user-accounts/export', [UserAccountController::class, 'export'])->name('user_accounts.export');


});