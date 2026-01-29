<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;


Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::command('rappel:rattachement-bl')
    ->weekdays()              // Lundi à vendredi
    ->everyThirtyMinutes()    // Toutes les 30 minutes
    ->between('8:00', '17:00'); // De 8h00 à 17h00

Schedule::command('audit:b2-archive')
    ->dailyAt('00:00');
