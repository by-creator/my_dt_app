<?php

namespace App\Http\Controllers;

use App\Models\RattachementBl;
use Illuminate\Http\Request;

class RattachementController extends Controller
{
    public function index()
    {
        $rattachements = RattachementBl::orderBy('id', 'desc')->get();
        return view('rattachement_bl.index', compact('rattachements'));
    }
}
