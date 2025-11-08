<?php

namespace App\Http\Controllers;

use App\Models\RattachementBl;
use Illuminate\Http\Request;

class RattachementController extends Controller
{
    public function index()
    {
        $rattachement_validations = RattachementBl::orderBy('id', 'asc')->get();
        $rattachements = RattachementBl::orderBy('id', 'desc')->get();
        return view('rattachement_bl.index', compact('rattachements', 'rattachement_validations'));
    }
}
