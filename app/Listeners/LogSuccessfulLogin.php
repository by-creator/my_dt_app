<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Log;

class LogSuccessfulLogin
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(Login $event)
    {
        Log::info('Connexion utilisateur', [
            'user_id' => $event->user->id,
            'email' => $event->user->email,
            'ip' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }
}
