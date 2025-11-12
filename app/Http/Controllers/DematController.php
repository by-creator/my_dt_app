<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DematController extends Controller
{
    public function validation(Request $request)
    {
        $data = $request->validate([
            'prenom' => 'required|string|max:255',
            'nom' => 'required|string|max:255',
            'email' => 'required|email',
            'bl' => 'required|string',
            'compte' => 'required|string',
            //'documents.*' => 'file',
        ]);

        echo $data['email'];
        
    }
}
