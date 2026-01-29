<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ActivityLogger
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        if (Auth::check()) {
            activity('http')
                ->causedBy(Auth::user())
                ->withProperties([
                    'role' => Auth::user()->role,
                    'user_id' => Auth::id(),
                    'email' => Auth::user()->email,
                    'method' => $request->method(),
                    'url' => $request->fullUrl(),
                    'route' => optional($request->route())->getName(),
                    'ip' => $request->ip(),
                    'user_agent' => $request->userAgent(),
                ])
                ->log('Action utilisateur');
            
        }

        return $response;
    }
}
