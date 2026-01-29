<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;



class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
{
    $user = Auth::user();

    if (
        !$user ||
        !$user->role ||
        $user->role->name !== 'ADMIN'
    ) {
        abort(403, 'ACCÈS RÉSERVÉ AUX ADMINISTRATEURS');
    }

    return $next($request);
}

}
