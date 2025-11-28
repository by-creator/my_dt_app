<?php

use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Ici, tu peux enregistrer toutes les routes pour ton API. Ces routes
| sont automatiquement préfixées par "/api" et utilisent le groupe
| de middleware "api".
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Exemple de route publique
Route::get('/ping', function () {
    return response()->json(['message' => 'API is working ✅']);
});

//api ordre-approche-vehicule
Route::post('/ask-powerbi/ordre-approche-vehicule', function(Request $request) {
    return response()->json([
        'BL' => $request->numero
    ]);
});

