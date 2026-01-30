

    <?php

    use App\Http\Controllers\GfaController;
    use Illuminate\Support\Facades\Route;

    Route::middleware('auth')->group(function () {

        Route::get('/gfa/guichet', [GfaController::class, 'guichet'])->name('gfa.guichet.me');
            
        Route::get('gfa/guichet/{guichet}', [GfaController::class, 'index'])->name('gfa.guichet');

        Route::get('/gfa/dashboard', [GfaController::class, 'dashboard'])->name('gfa.dashboard');
    });
