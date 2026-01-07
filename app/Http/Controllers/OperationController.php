<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\OperationsImport;
use App\Exports\StatsExport;
use Maatwebsite\Excel\Facades\Excel;

class OperationController extends Controller
{
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
