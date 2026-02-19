<?php

use App\Http\Controllers\{
    DashboardController,
    DematController,
    DossierFacturationBonController,
    DossierFacturationController,
    DossierFacturationFactureController,
    DossierFacturationProformaController,
    GuichetController,
    IpakiExtranetServiceController,
    RattachementController,
};

use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {

    Route::get('/rattachement', [RattachementController::class, 'index'])->name('rattachement.index');
    Route::get('/rattachement/list', [RattachementController::class, 'list'])->name('rattachement.list');

    Route::put('/rattachement/create/{id}', [RattachementController::class, 'create'])->name('rattachement.create');
    Route::put('/rattachement/update/{id}', [RattachementController::class, 'update'])->name('rattachement.update');
    Route::put('/rattachement/delete/{id}', [RattachementController::class, 'delete'])->name('rattachement.delete');



    Route::get('/dossier-facturation', [DossierFacturationController::class, 'index'])->name('dossier_facturation.index');
    Route::post('/dossier-facturation/store', [DossierFacturationController::class, 'store'])->name('dossier_facturation.store');

    Route::get('dossier-facturation/index-validation', [DossierFacturationController::class, 'indexValidation'])->name('dossier_facturation.validation-index');
    Route::get('dossier-facturation/index-remise', [DossierFacturationController::class, 'indexRemise'])->name('dossier_facturation.remise-index');
    Route::get('dossier-facturation/index-paiement', [DossierFacturationController::class, 'indexPaiement'])->name('dossier_facturation.paiement-index');

    Route::get('dossier-facturation/index-tuto-video', [DossierFacturationController::class, 'indexTutoVideo'])->name('dossier_facturation.tuto-video-index');
    Route::get('dossier-facturation/index-tuto-pdf', [DossierFacturationController::class, 'indexTutoPdf'])->name('dossier_facturation.tuto-pdf-index');

    Route::post('/dossier-facturation/send-validation', [IpakiExtranetServiceController::class, 'sendValidation'])->name('dossier_facturation.send-validation');
    Route::post('/dossier-facturation/validation', [DematController::class, 'validation'])->name('dossier_facturation.validation');
    Route::post('/dossier-facturation/remise', [DematController::class, 'remise'])->name('dossier_facturation.remise');

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
