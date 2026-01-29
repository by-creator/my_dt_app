<?php

use App\Http\Controllers\{
    AuditController,
    DashboardController,
    RoleController,
    UserController,
};

use App\Exports\ActivitiesExport;
use Maatwebsite\Excel\Facades\Excel;


use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use Livewire\Volt\Volt;

use Barryvdh\DomPDF\Facade\Pdf;
use Spatie\Activitylog\Models\Activity;


Route::middleware('auth')->group(function () {

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
});

Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/audit', [AuditController::class, 'index'])
            ->name('audit');
    });


Route::get('/admin/audit/export/excel', function () {
    return Excel::download(
        new ActivitiesExport(request('from'), request('to')),
        'audit_logs.xlsx'
    );
})->middleware(['auth', 'admin'])->name('admin.audit.export.excel');

Route::get('/admin/audit/export/pdf', function () {

    $query = Activity::with('causer')->latest();

    if (request('from')) {
        $query->whereDate('created_at', '>=', request('from'));
    }

    if (request('to')) {
        $query->whereDate('created_at', '<=', request('to'));
    }

    $activities = $query->get();

    $pdf = Pdf::loadView('admin.audit.pdf', compact('activities'));

    return $pdf->download('audit_logs.pdf');

})->middleware(['auth', 'admin'])->name('admin.audit.export.pdf');


