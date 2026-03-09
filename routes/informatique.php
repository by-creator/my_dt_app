<?php

use App\Http\Controllers\UserAccountController;
use App\Http\Controllers\MachineController;
use App\Http\Controllers\PosteFixeController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {

    Route::get('/user-accounts', [UserAccountController::class, 'index'])->name('user_accounts.index');
    Route::post('/user-accounts/create', [UserAccountController::class, 'create'])->name('user_accounts.create');
    Route::put('/user-accounts/update/{id}', [UserAccountController::class, 'update'])->name('user_accounts.update');
    Route::delete('/user-accounts/delete/{id}', [UserAccountController::class, 'delete'])->name('user_accounts.delete');
    Route::post('/user-accounts/import', [UserAccountController::class, 'import'])->name('user_accounts.import');
    Route::get('/user-accounts/export', [UserAccountController::class, 'export'])->name('user_accounts.export');

    // Machines
    Route::get('/machines', [MachineController::class, 'index'])->name('machines.index');
    Route::post('/machines/create', [MachineController::class, 'create'])->name('machines.create');
    Route::put('/machines/update/{id}', [MachineController::class, 'update'])->name('machines.update');
    Route::delete('/machines/delete/{id}', [MachineController::class, 'delete'])->name('machines.delete');
    Route::post('/machines/import', [MachineController::class, 'import'])->name('machines.import');
    Route::get('/machines/export', [MachineController::class, 'export'])->name('machines.export');

    // Postes Fixes
    Route::get('/poste-fixes', [PosteFixeController::class, 'index'])->name('poste_fixes.index');
    Route::post('/poste-fixes/create', [PosteFixeController::class, 'create'])->name('poste_fixes.create');
    Route::put('/poste-fixes/update/{id}', [PosteFixeController::class, 'update'])->name('poste_fixes.update');
    Route::delete('/poste-fixes/delete/{id}', [PosteFixeController::class, 'delete'])->name('poste_fixes.delete');
    Route::post('/poste-fixes/import', [PosteFixeController::class, 'import'])->name('poste_fixes.import');
    Route::get('/poste-fixes/export', [PosteFixeController::class, 'export'])->name('poste_fixes.export');

});