<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Auth\Events\Logout;
use Illuminate\Support\Facades\Log;



class LogSuccessfulLogout
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
    public function handle(Logout $event)
    {
        Log::info('Déconnexion utilisateur', [
            'user_id' => $event->user->id,
            'email' => $event->user->email,
            'ip' => request()->ip(),
        ]);
    }
}
