<?php

use Illuminate\Support\Facades\Broadcast;

// Canal public pour l'écran d'affichage
Broadcast::channel('tickets', function () {
    return true;
});

// Canal public pour chaque agent
Broadcast::channel('agent.{agentId}', function () {
    return true;
});
