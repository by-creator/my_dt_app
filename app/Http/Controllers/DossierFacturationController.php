<?php

namespace App\Http\Controllers;

use App\Http\Requests\{
    StoreDossierFacturationRequest,
    UpdateUserRequest,
    ImportUsersRequest
};
use App\Services\Dossier\{
    DossierFacturationService,
    TutorialService,
    UserManagementService
};
use App\Models\{
    DossierFacturation,
    Role,
    User
};
use App\Exports\UsersExport;
use App\Imports\UsersImport;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class DossierFacturationController extends Controller
{
    public function __construct(
        private DossierFacturationService $dossierService,
        private TutorialService $tutorialService,
        private UserManagementService $userService
    ) {}

    public function index() { return view('dossier_facturation.form'); }
    public function indexValidation() { return view('dossier_facturation.validation'); }
    public function indexPaiement() { return view('dossier_facturation.paiement'); }
    public function indexRemise() { return view('dossier_facturation.remise'); }

    public function indexTutoVideo()
    {
        return view('dossier_facturation.tuto_video', [
            'videos' => $this->tutorialService->videos(),
            'user' => Auth::user()
        ]);
    }

    public function indexTutoPdf()
    {
        return view('dossier_facturation.tuto_pdf', [
            'pdfs' => $this->tutorialService->pdfs()
        ]);
    }

    public function list()
    {
        return view('dossier_facturation.list', [
            'dossiers' => DossierFacturation::latest()->get()
        ]);
    }

    public function show(DossierFacturation $dossier)
    {
        return view('dossier_facturation.show', compact('dossier'));
    }

    public function store(StoreDossierFacturationRequest $request)
    {
        $this->dossierService->store($request);

        return back()->with('success', 'Documents enregistrés avec succès !');
    }

    public function listClient()
    {
        $roleId = Role::where('name', 'client_facturation')->value('id');

        return view('dossier_facturation.list_client', [
            'users' => User::where('role_id', $roleId)->latest()->get(),
            'roles' => Role::all(),
            'user' => Auth::user()
        ]);
    }

    public function update(UpdateUserRequest $request, $id)
    {
        $user = User::findOrFail($id);
        $this->userService->update($user, $request->validated());

        return redirect()
            ->route('dossier_facturation.list_client')
            ->with('update', 'Utilisateur mis à jour avec succès.');
    }

    public function delete($id)
    {
        $this->userService->delete(User::findOrFail($id));

        return redirect()
            ->route('dossier_facturation.list_client')
            ->with('delete', 'Utilisateur supprimé avec succès.');
    }

    public function export()
    {
        return Excel::download(new UsersExport, 'users.xlsx');
    }

    public function import(ImportUsersRequest $request)
    {
        Excel::import(new UsersImport, $request->file('file'));

        return redirect()
            ->route('dossier_facturation.list_client')
            ->with('success', 'Utilisateurs importés avec succès.');
    }
}
