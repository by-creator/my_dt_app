<?php

namespace App\Http\Controllers;

use App\Models\DossierFacturation;
use App\Models\User;
use Illuminate\Http\Request;

class DossierFacturationBonController extends Controller
{
    public function bon()
    {
        $dossiers = DossierFacturation::orderBy('id', 'desc')->get();
        $users = User::all();
        return view('dossier_facturation.bon', compact('dossiers', 'users'));
    }
}
