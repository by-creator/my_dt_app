<?php

use App\Http\Controllers\DisplayController;

/*
|--------------------------------------------------------------------------
| Display routes (sans facade)
|--------------------------------------------------------------------------
*/

$app->router->get('/display', [DisplayController::class, 'index']);
