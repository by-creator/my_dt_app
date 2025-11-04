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

    public function create(Request $request)
    {
        $data = $request->validate([
            'created_time' => 'required|date',
            'employee_end_date' => 'nullable|date|after_or_equal:created_time',

            'display_name' => 'required|string|max:255',
            'department' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'job_title' => 'required|string|max:255',
        ]);


        UserAccount::create($data);

        return redirect()->back()->with('create', 'Compte créé avec succès.');
    }

    public function update(Request $request, $id)
    {
        $user_account = UserAccount::findOrFail($id);

        $user_account->created_time = $request->created_time;
        $user_account->employee_end_date = $request->employee_end_date;
        $user_account->display_name = $request->display_name;
        $user_account->department = $request->department;
        $user_account->email = $request->email;
        $user_account->job_title = $request->job_title;

        $user_account->save();

        return redirect()->back()->with('update', 'Compte mis à jour avec succès.');
    }

    public function delete($id)
    {
        $user_account = UserAccount::findOrFail($id);
        $user_account->delete();

        return redirect()->back()->with('delete', 'Compte supprimé avec succès.');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,xlsx,txt',
        ]);

        Excel::import(new UserAccountsImport, $request->file('file'));

        return response()->json(['message' => 'Importation terminée']);
    }

    public function export()
    {
        $fileName = 'user_accounts_' . now()->format('Ymd_His') . '.csv';
        return Excel::download(new UserAccountsExport, $fileName);
    }
}
