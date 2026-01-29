<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Models\Activity;
use App\Services\Audit\AuditExportB2Service;



class AuditController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $query = Activity::with('causer')->latest();

        if ($request->filled('from')) {
            $query->whereDate('created_at', '>=', $request->from);
        }

        if ($request->filled('to')) {
            $query->whereDate('created_at', '<=', $request->to);
        }

        $activities = $query->paginate(10)->withQueryString();

        return view('admin.audit.index', compact('activities', 'user'));
    }
}
