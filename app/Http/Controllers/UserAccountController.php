<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\UserAccountsImport;
use App\Exports\UserAccountsExport;
use App\Models\UserAccount;
use Maatwebsite\Excel\Facades\Excel;

class UserAccountController extends Controller
{
    public function index()
    {
        $user_accounts = UserAccount::orderBy('id', 'desc')->get();
        return view('user_accounts.index', compact('user_accounts'));
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,xlsx,txt',
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
