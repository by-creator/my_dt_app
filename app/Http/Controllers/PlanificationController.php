<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\OperationsImport;
use App\Exports\StatsExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;


class PlanificationController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('planification.recap_debarquement',compact('user'));
    }
        
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls',
        ]);

        $import = new OperationsImport();
        Excel::import($import, $request->file('file'));

        return Excel::download(new StatsExport($import->stats), 'stats.xlsx');
    }
}
