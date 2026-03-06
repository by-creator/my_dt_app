<?php

use App\Http\Controllers\EdiConversionController;
use Illuminate\Support\Facades\Route;

Route::prefix('edi')->group(function () {
    Route::get('/',                      [EdiConversionController::class, 'index'])->name('edi.index');
    Route::post('/preview',              [EdiConversionController::class, 'preview'])->name('edi.preview');
    Route::get('/download/{token}',      [EdiConversionController::class, 'download'])->name('edi.download');
    Route::get('/download-xlsx/{token}', [EdiConversionController::class, 'downloadXlsx'])->name('edi.download.xlsx');
});
