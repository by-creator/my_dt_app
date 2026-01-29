<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Models\Activity;


class AuditController extends Controller
{
    public function index()
    {
         $user = Auth::user();
        $activities = Activity::with('causer')
            ->latest()
            ->paginate(50);

        return view('admin.audit.index', compact('activities', 'user'));
    }
}
