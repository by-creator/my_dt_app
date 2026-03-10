<?php

use App\Http\Controllers\AgentController;
use App\Http\Controllers\AgentPanelController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ScreenController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\TicketController;
use App\Models\ScanToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

/* =====================================================
   ÉCRAN PUBLIC (racine)
   ===================================================== */
Route::get('/screen', [ScreenController::class, 'index'])
    ->name('public.screen');

/* =====================================================
   PRISE DE TICKET (QR CODE → SCAN → CREATE → SHOW)
   ===================================================== */
Route::get('/scan', function (Request $request) {
    $token = Str::uuid();

    ScanToken::create([
        'token'      => $token,
        'ip_address' => $request->ip(),
        'used'       => false,
        'expires_at' => now()->addMinutes(2),
    ]);

    session(['scan_token' => $token]);

    Log::info('Token généré', [
        'token'      => $token,
        'ip'         => $request->ip(),
        'expires_at' => now()->addMinutes(2)->toDateTimeString(),
    ]);

    return redirect()->route('ticket.create', ['token' => $token]);
})->name('ticket.scan');

Route::get('/ticket/create', [TicketController::class, 'create'])->name('ticket.create');
Route::post('/ticket',       [TicketController::class, 'store'])->name('ticket.store');
Route::get('/ticket/{ticket}', [TicketController::class, 'show'])->name('ticket.show');

Route::post('/tickets/truncate', [TicketController::class, 'truncate'])->name('tickets.truncate');

/* =====================================================
   PANEL AGENT
   ===================================================== */
Route::get('/agent/{agent}',                          [AgentPanelController::class, 'index'])->name('agent.dashboard');
Route::post('/agent/{agent}/call',                    [AgentPanelController::class, 'call'])->name('agent.call');
Route::post('/agent/{agent}/rappel',                  [AgentPanelController::class, 'rappel'])->name('agent.rappel');
Route::post('/agent/{agent}/close/{ticket}/{status}', [AgentPanelController::class, 'close'])->name('agent.close');
Route::get('/agent/{agent}/waiting',                  [AgentPanelController::class, 'waiting'])->name('agent.waiting');

/* =====================================================
   ADMIN – SERVICES & AGENTS (CRUD)
   ===================================================== */
Route::resource('/admin/services', ServiceController::class);
Route::resource('/admin/agents',   AgentController::class);

/* =====================================================
   TABLEAU DE BORD TICKETS
   ===================================================== */
Route::get('/gfa/tickets-detail',
    [DashboardController::class, 'gfaTicketsDetail']
)->name('gfa.tickets-detail');

Route::get('/gfa/tickets-detail/export',
    [DashboardController::class, 'gfaExportTicketsDetail']
)->name('gfa.tickets-detail.export');

Route::get('/file-attente/overview',
    [DashboardController::class, 'fileAttenteOverview']
)->name('file-attente.overview');
