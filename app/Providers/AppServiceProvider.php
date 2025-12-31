<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;




class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

        view()->composer('*', function ($view) {
        if (Auth::check()) {
            $user = Cache::remember(
                'auth_user_' . Auth::id(),
                now()->addMinutes(10),
                fn () => Auth::user()
            );

            $view->with('authUser', $user);
        }
    });

        Route::middleware('api')
        ->prefix('api')
        ->group(base_path('routes/api.php'));

        if (app()->environment('production')) {
            URL::forceScheme('https');
        }
    }
}
