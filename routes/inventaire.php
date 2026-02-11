<?php

use App\Http\Controllers\{
    OrdinateurController,
    ClavierController,
    SourisControlller,
    EcranController,
    StationController,
    TelephoneFixeController,
    TelephoneMobileController,
};
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {

    Route::prefix('ordinateur')->name('ordinateur.')->controller(OrdinateurController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'create')->name('create');
        Route::put('{id}', 'update')->name('update');
        Route::delete('{id}', 'delete')->name('delete');
        Route::post('import', 'import')->name('import');
        Route::get('export', 'export')->name('export');
    });
});
Route::middleware('auth')->group(function () {

    Route::prefix('clavier')->name('clavier.')->controller(ClavierController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'create')->name('create');
        Route::put('{id}', 'update')->name('update');
        Route::delete('{id}', 'delete')->name('delete');
        Route::post('import', 'import')->name('import');
        Route::get('export', 'export')->name('export');
    });
});
Route::middleware('auth')->group(function () {

    Route::prefix('souris')->name('souris.')->controller(SourisControlller::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'create')->name('create');
        Route::put('{id}', 'update')->name('update');
        Route::delete('{id}', 'delete')->name('delete');
        Route::post('import', 'import')->name('import');
        Route::get('export', 'export')->name('export');
    });
});
Route::middleware('auth')->group(function () {

    Route::prefix('ecran')->name('ecran.')->controller(EcranController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'create')->name('create');
        Route::put('{id}', 'update')->name('update');
        Route::delete('{id}', 'delete')->name('delete');
        Route::post('import', 'import')->name('import');
        Route::get('export', 'export')->name('export');
    });
});
Route::middleware('auth')->group(function () {

    Route::prefix('station')->name('station.')->controller(StationController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'create')->name('create');
        Route::put('{id}', 'update')->name('update');
        Route::delete('{id}', 'delete')->name('delete');
        Route::post('import', 'import')->name('import');
        Route::get('export', 'export')->name('export');
    });
});
Route::middleware('auth')->group(function () {

    Route::prefix('telephone-fixe')->name('telephone-fixe.')->controller(TelephoneFixeController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'create')->name('create');
        Route::put('{id}', 'update')->name('update');
        Route::delete('{id}', 'delete')->name('delete');
        Route::post('import', 'import')->name('import');
        Route::get('export', 'export')->name('export');
    });
});
Route::middleware('auth')->group(function () {

    Route::prefix('telephone-mobiles')
        ->name('telephone-mobiles.')
        ->controller(TelephoneMobileController::class)
        ->group(function () {

            Route::get('/', 'index')->name('index');
            Route::post('/store', 'store')->name('store');

            Route::put('/{telephoneMobile}', 'update')->name('update');
            Route::delete('/{telephoneMobile}', 'destroy')->name('destroy');

            Route::post('/import', 'import')->name('import');
            Route::get('/export', 'export')->name('export');
        });
});

