<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController as FortifyAuthController;

class LoginController extends FortifyAuthController
{
    public function store(Request $request)
    {
        // 1. Validation
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // 2. Authentification
        if (!Auth::attempt($request->only('email', 'password'), $request->filled('remember'))) {
            return back()->withErrors([
                'email' => 'Identifiants incorrects.',
            ]);
        }

        // 3. Récupération user
        $user = Auth::user();

        // 4. Redirection après login
        return redirect()->route('dashboard');
    }
}
