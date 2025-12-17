<?php

use App\Http\Controllers\ClavierController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DematController;
use App\Http\Controllers\DossierFacturationBonController;
use App\Http\Controllers\DossierFacturationController;
use App\Http\Controllers\DossierFacturationFactureController;
use App\Http\Controllers\DossierFacturationProformaController;
use App\Http\Controllers\EcranController;
use App\Http\Controllers\IpakiController;
use App\Http\Controllers\IpakiExtranetServiceController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\OrdinateurController;
use App\Http\Controllers\OrdreApprocheController;
use App\Http\Controllers\RattachementController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SourisControlller;
use App\Http\Controllers\StationController;
use App\Http\Controllers\TelephoneFixeController;
use App\Http\Controllers\UnifyController;
use App\Http\Controllers\UserAccountController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserImportController;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use Livewire\Volt\Volt;



Route::get('/', function () {
    return view('index');
})->name('home');

Route::post('/login', [LoginController::class, 'store'])
    ->middleware(['guest'])
    ->name('login.custom.store');

Route::get('/demat', [DematController::class, 'index'])->name('demat.index');


Route::post('/demat/send-validation', [IpakiExtranetServiceController::class, 'sendValidation'])->name('ies.send-validation');
Route::post('/demat/validation', [DematController::class, 'validation'])->name('demat.validation');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile')->name('settings');

    Volt::route('settings/profile', 'settings.profile')->name('profile.edit');
    Volt::route('settings/password', 'settings.password')->name('user-password.edit');
    Volt::route('settings/appearance', 'settings.appearance')->name('appearance.edit');

    Volt::route('settings/two-factor', 'settings.two-factor')
        ->middleware(
            when(
                Features::canManageTwoFactorAuthentication()
                    && Features::optionEnabled(Features::twoFactorAuthentication(), 'confirmPassword'),
                ['password.confirm'],
                [],
            ),
        )
        ->name('two-factor.show');

    Route::get('/dashboard/logout', [DashboardController::class, 'logout'])->name('dashboard.logout');

    Route::get('/role', [RoleController::class, 'index'])->name('role.index');

    Route::post('/role/create', [RoleController::class, 'create'])->name('role.create');
    Route::put('/role/update/{id}', [RoleController::class, 'update'])->name('role.update');
    Route::delete('/role/delete/{id}', [RoleController::class, 'delete'])->name('role.delete');
    Route::post('/role/import', [RoleController::class, 'import'])->name('role.import');
    Route::get('/role/export', [RoleController::class, 'export'])->name('role.export');


    Route::get('/user', [UserController::class, 'index'])->name('user.index');

    Route::post('/user/create', [UserController::class, 'create'])->name('user.create');
    Route::put('/user/update/{id}', [UserController::class, 'update'])->name('user.update');
    Route::delete('/user/delete/{id}', [UserController::class, 'delete'])->name('user.delete');
    Route::post('/user/import', [UserController::class, 'import'])->name('user.import');
    Route::get('/user/export', [UserController::class, 'export'])->name('user.export');


    Route::get('/unify', [UnifyController::class, 'index'])->name('unify.index');
    Route::get('/unify/create', [UnifyController::class, 'create'])->name('unify.create');
    Route::get('/unify/tutorial', [UnifyController::class, 'tutorial'])->name('unify.tutorial');
    Route::post('/unify/add', [UnifyController::class, 'add'])->name('unify.add');


    Route::get('/ipaki/admin', [IpakiController::class, 'admin'])->name('ipaki.admin');
    Route::get('/ipaki/list', [IpakiController::class, 'list'])->name('ipaki.list');
    Route::put('/ipaki/update/{id}', [IpakiController::class, 'update'])->name('ipaki.update');
    Route::delete('/ipaki/delete/{id}', [IpakiController::class, 'delete'])->name('ipaki.delete');
    Route::post('/ipaki/import', [IpakiController::class, 'import'])->name('ipaki.import');
    Route::get('/ipaki/export', [IpakiController::class, 'export'])->name('ipaki.export');
    Route::get('/ipaki/truncate', [IpakiController::class, 'truncate'])->name('ipaki.truncate');
    Route::post('/ipaki/filter', [IpakiController::class, 'filter'])->name('ipaki.filter');
    Route::post('/ipaki/form', [IpakiController::class, 'form'])->name('ipaki.form');
    Route::post('/ipaki/create', [IpakiController::class, 'create'])->name('ipaki.create');


    Route::get('/ies/validation', [IpakiExtranetServiceController::class, 'validation'])->name('ies.validation');
    Route::get('/ies/create', [IpakiExtranetServiceController::class, 'create'])->name('ies.create');
    Route::get('/ies/link', [IpakiExtranetServiceController::class, 'link'])->name('ies.link');
    Route::get('/ies/reset-password', [IpakiExtranetServiceController::class, 'resetPassword'])->name('ies.reset-password');
    Route::post('/ies/send-validation-account', [IpakiExtranetServiceController::class, 'sendValidationAccount'])->name('ies.send-validation-account');
    Route::post('/ies/send-create', [IpakiExtranetServiceController::class, 'sendCreate'])->name('ies.send-create');
    Route::post('/ies/send-link', [IpakiExtranetServiceController::class, 'sendLink'])->name('ies.send-link');
    Route::post('/ies/send-reset-password', [IpakiExtranetServiceController::class, 'sendResetPassword'])->name('ies.send-reset-password');

    Route::get('/ordinateur/index', [OrdinateurController::class, 'index'])->name('ordinateur.index');
    Route::post('/ordinateur/create', [OrdinateurController::class, 'create'])->name('ordinateur.create');
    Route::put('/ordinateur/update/{id}', [OrdinateurController::class, 'update'])->name('ordinateur.update');
    Route::delete('/ordinateur/delete/{id}', [OrdinateurController::class, 'delete'])->name('ordinateur.delete');
    Route::post('/ordinateur/import', [OrdinateurController::class, 'import'])->name('ordinateur.import');
    Route::get('/ordinateur/export', [OrdinateurController::class, 'export'])->name('ordinateur.export');

    Route::get('/clavier/index', [ClavierController::class, 'index'])->name('clavier.index');
    Route::post('/clavier/create', [ClavierController::class, 'create'])->name('clavier.create');
    Route::put('/clavier/update/{id}', [ClavierController::class, 'update'])->name('clavier.update');
    Route::delete('/clavier/delete/{id}', [ClavierController::class, 'delete'])->name('clavier.delete');
    Route::post('/clavier/import', [ClavierController::class, 'import'])->name('clavier.import');
    Route::get('/clavier/export', [ClavierController::class, 'export'])->name('clavier.export');

    Route::get('/souris/index', [SourisControlller::class, 'index'])->name('souris.index');
    Route::post('/souris/create', [SourisControlller::class, 'create'])->name('souris.create');
    Route::put('/souris/update/{id}', [SourisControlller::class, 'update'])->name('souris.update');
    Route::delete('/souris/delete/{id}', [SourisControlller::class, 'delete'])->name('souris.delete');
    Route::post('/souris/import', [SourisControlller::class, 'import'])->name('souris.import');
    Route::get('/souris/export', [SourisControlller::class, 'export'])->name('souris.export');

    Route::get('/ecran/index', [EcranController::class, 'index'])->name('ecran.index');
    Route::post('/ecran/create', [EcranController::class, 'create'])->name('ecran.create');
    Route::put('/ecran/update/{id}', [EcranController::class, 'update'])->name('ecran.update');
    Route::delete('/ecran/delete/{id}', [EcranController::class, 'delete'])->name('ecran.delete');
    Route::post('/ecran/import', [EcranController::class, 'import'])->name('ecran.import');
    Route::get('/ecran/export', [EcranController::class, 'export'])->name('ecran.export');

    Route::get('/station/index', [StationController::class, 'index'])->name('station.index');
    Route::post('/station/create', [StationController::class, 'create'])->name('station.create');
    Route::put('/station/update/{id}', [StationController::class, 'update'])->name('station.update');
    Route::delete('/station/delete/{id}', [StationController::class, 'delete'])->name('station.delete');
    Route::post('/station/import', [StationController::class, 'import'])->name('station.import');
    Route::get('/station/export', [StationController::class, 'export'])->name('station.export');

    Route::get('/telephone-fixe', [TelephoneFixeController::class, 'index'])->name('telephone-fixe.index');
    Route::post('/telephone-fixe/create', [TelephoneFixeController::class, 'create'])->name('telephone-fixe.create');
    Route::put('/telephone-fixe/update/{id}', [TelephoneFixeController::class, 'update'])->name('telephone-fixe.update');
    Route::delete('/telephone-fixe/delete/{id}', [TelephoneFixeController::class, 'delete'])->name('telephone-fixe.delete');
    Route::post('/telephone-fixe/import', [TelephoneFixeController::class, 'import'])->name('telephone-fixe.import');
    Route::get('/telephone-fixe/export', [TelephoneFixeController::class, 'export'])->name('telephone-fixe.export');
    Route::get('/telephone-fixe/tutorial', [TelephoneFixeController::class, 'tutorial'])->name('telephone-fixe.tutorial');


    Route::get('/user-accounts', [UserAccountController::class, 'index'])->name('user_accounts.index');

    Route::post('/user-accounts/create', [UserAccountController::class, 'create'])->name('user_accounts.create');
    Route::put('/user-accounts/update/{id}', [UserAccountController::class, 'update'])->name('user_accounts.update');
    Route::delete('/user-accounts/delete/{id}', [UserAccountController::class, 'delete'])->name('user_accounts.delete');
    Route::post('/user-accounts/import', [UserAccountController::class, 'import'])->name('user_accounts.import');
    Route::get('/user-accounts/export', [UserAccountController::class, 'export'])->name('user_accounts.export');


    Route::get('/rattachement', [RattachementController::class, 'index'])->name('rattachement.index');
    Route::get('/rattachement/list', [RattachementController::class, 'list'])->name('rattachement.list');

    Route::put('/rattachement/create/{id}', [RattachementController::class, 'create'])->name('rattachement.create');
    Route::put('/rattachement/update/{id}', [RattachementController::class, 'update'])->name('rattachement.update');
    Route::put('/rattachement/delete/{id}', [RattachementController::class, 'delete'])->name('rattachement.delete');

    Route::get('/ordre-approche/index', [OrdreApprocheController::class, 'index'])->name('ordre_approche.index');

    Route::post('/ordre-approche/create', [OrdreApprocheController::class, 'create'])->name('ordre_approche.create');
    Route::put('/ordre-approche/update/{id}', [OrdreApprocheController::class, 'update'])->name('ordre_approche.update');
    Route::delete('/ordre-approche/delete/{id}', [OrdreApprocheController::class, 'delete'])->name('ordre_approche.delete');

    Route::get('/dossier-facturation', [DossierFacturationController::class, 'index'])->name('dossier_facturation.index');
    Route::post('/dossier-facturation/store', [DossierFacturationController::class, 'store'])->name('dossier_facturation.store');

    Route::get('dossier-facturation/index-validation', [DossierFacturationController::class, 'indexValidation'])->name('dossier_facturation.validation-index');
    Route::get('dossier-facturation/index-paiement', [DossierFacturationController::class, 'indexPaiement'])->name('dossier_facturation.paiement-index');

    Route::get('dossier-facturation/index-tuto-video', [DossierFacturationController::class, 'indexTutoVideo'])->name('dossier_facturation.tuto-video-index');
    Route::get('dossier-facturation/index-tuto-pdf', [DossierFacturationController::class, 'indexTutoPdf'])->name('dossier_facturation.tuto-pdf-index');

    Route::post('/dossier-facturation/send-validation', [IpakiExtranetServiceController::class, 'sendValidation'])->name('dossier_facturation.send-validation');
    Route::post('/dossier-facturation/validation', [DematController::class, 'validation'])->name('dossier_facturation.validation');

    Route::get('/dossier-facturation/list', [DossierFacturationController::class, 'list'])->name('dossier_facturation.list');
    Route::get('/dossier-facturations/{dossier}', [DossierFacturationController::class, 'show'])->name('dossier_facturation.show');
    Route::get('/dossier-facturation/facture', [DossierFacturationController::class, 'facture'])->name('dossier_facturation.facture');


    Route::get('/dossier-facturation/proforma', [DossierFacturationProformaController::class, 'proforma'])->name('dossier_facturation.proforma');
    Route::get('/dossier-facturation/proforma/list', [DossierFacturationProformaController::class, 'list'])->name('dossier_facturation.proforma.list');

    Route::post('/dossier-facturations/{id}/proforma/generate', [DossierFacturationProformaController::class, 'generate'])
        ->name('dossier_facturation.proforma.generate');

    Route::post('/dossier-facturations/{id}/proforma/validate', [DossierFacturationProformaController::class, 'validate'])
        ->name('dossier_facturation.proforma.validate');

    Route::post('/dossier-facturations/{id}/proforma/delete', [DossierFacturationProformaController::class, 'delete'])
        ->name('dossier_facturation.proforma.delete');

    Route::post('/dossier-facturation/proforma/send/{id}', [DossierFacturationProformaController::class, 'sendDocuments'])->name('dossier_facturation.proforma.send');
    Route::put('/dossier-facturation/proforma/reject/{id}', [DossierFacturationProformaController::class, 'rejectDocuments'])->name('dossier_facturation.proforma.reject');
    Route::post('/dossier-facturation/proforma/relance/{id}', [DossierFacturationProformaController::class, 'relanceDocuments'])->name('dossier_facturation.proforma.relance');


    Route::get('/dossier-facturation/facture', [DossierFacturationFactureController::class, 'facture'])->name('dossier_facturation.facture');
    Route::get('/dossier-facturation/facture/list', [DossierFacturationFactureController::class, 'list'])->name('dossier_facturation.facture.list');


    Route::post('/dossier-facturations/{id}/facture/complement', [DossierFacturationFactureController::class, 'complement'])
        ->name('dossier_facturation.facture.complement');

    Route::post('/dossier-facturations/{id}/facture/validate', [DossierFacturationFactureController::class, 'validate'])
        ->name('dossier_facturation.facture.validate');

    Route::post('/dossier-facturation/facture/send/{id}', [DossierFacturationFactureController::class, 'sendDocuments'])->name('dossier_facturation.facture.send');
    Route::put('/dossier-facturation/facture/reject/{id}', [DossierFacturationFactureController::class, 'rejectDocuments'])->name('dossier_facturation.facture.reject');
    Route::post('/dossier-facturation/facture/relance/{id}', [DossierFacturationFactureController::class, 'relanceDocuments'])->name('dossier_facturation.facture.relance');


    Route::get('/dossier-facturation/bon', [DossierFacturationBonController::class, 'bon'])->name('dossier_facturation.bon');
    Route::get('/dossier-facturation/bon/list', [DossierFacturationBonController::class, 'list'])->name('dossier_facturation.bon.list');

    Route::post('/dossier-facturation/bon/send/{id}', [DossierFacturationBonController::class, 'sendDocuments'])->name('dossier_facturation.bon.send');
    Route::put('/dossier-facturation/bon/reject/{id}', [DossierFacturationBonController::class, 'rejectDocuments'])->name('dossier_facturation.bon.reject');
    Route::post('/dossier-facturation/bon/relance/{id}', [DossierFacturationBonController::class, 'relanceDocuments'])->name('dossier_facturation.bon.relance');


    Route::get('/dossier-facturation/list/client', [DossierFacturationController::class, 'listClient'])->name('dossier_facturation.list_client');

    Route::put('/dossier-facturation/update/{id}', [DossierFacturationController::class, 'update'])->name('dossier_facturation.update');
    Route::delete('/dossier-facturation/delete/{id}', [DossierFacturationController::class, 'delete'])->name('dossier_facturation.delete');
    Route::post('/dossier-facturation/import', [DossierFacturationController::class, 'import'])->name('dossier_facturation.import');
    Route::get('/dossier-facturation/export', [DossierFacturationController::class, 'export'])->name('dossier_facturation.export');
});
