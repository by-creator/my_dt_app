<?php

namespace App\Http\Middleware;

use App\Mail\SecurityAlertMail;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

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

        $patterns = [
            '<script',
            'SELECT ',
            'UNION ',
            '--',
            ' OR ',
            ' AND ',
        ];

        $content = $request->fullUrl() . ' ' . json_encode($request->all());

        $suspicious = collect($patterns)->contains(
            fn($p) => str_contains(strtoupper($content), strtoupper($p))
        );

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
                ->log($suspicious ? 'Tentative suspecte' : 'Action utilisateur');
        }

        if ($suspicious) {
            Mail::to('bongoyebamarcdamien@yahoo.fr')
                ->send(new SecurityAlertMail($request));
        }


        return $response;
    }
}
