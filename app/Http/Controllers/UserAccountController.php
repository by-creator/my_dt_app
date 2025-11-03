<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\UserAccountsImport;
use App\Exports\UserAccountsExport;
use Maatwebsite\Excel\Facades\Excel;

class UserAccountController extends Controller
{
    public function import(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,xlsx,txt',
        ]);

        Excel::import(new UserAccountsImport, $request->file('csv_file'));

        return response()->json(['message' => 'Importation terminée']);
    }

    public function export()
    {
        $fileName = 'user_accounts_' . now()->format('Ymd_His') . '.csv';
        return Excel::download(new UserAccountsExport, $fileName);
    }
}
