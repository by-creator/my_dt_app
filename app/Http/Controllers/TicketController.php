<?php

namespace App\Http\Controllers;

use App\Events\TicketCreated;
use App\Models\Service;
use App\Models\ScanToken;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TicketController extends Controller
{
    private function isOpen(): bool
    {
        $now = now();
        return $now->between(now()->setTime(8, 0), now()->setTime(17, 0));
    }

    public function create(Request $request)
    {
        if (!$this->isOpen()) {
            return redirect('/')->with('info', 'La borne est ouverte de 8h à 17h uniquement.');
        }

        $tokenValue = $request->query('token', session('scan_token'));

        $scanToken = ScanToken::where('token', $tokenValue)
            ->where('used', false)
            ->where('expires_at', '>', now())
            ->first();

        if (!$scanToken) {
            Log::warning('Token invalide ou expiré', ['token' => $tokenValue]);
            abort(403, 'Token invalide ou déjà utilisé');
        }

        session(['scan_token' => $tokenValue]);

        return view('ticket.create', [
            'services'  => Service::all(),
            'formToken' => $tokenValue,
        ]);
    }

    public function store(Request $request)
    {
        if (!$this->isOpen()) {
            return redirect('/')->with('info', 'La borne est ouverte de 8h à 17h uniquement.');
        }

        $request->validate([
            'service_id' => 'required|exists:services,id',
            'token'      => 'required',
        ]);

        DB::beginTransaction();

        try {
            $scanToken = ScanToken::where('token', $request->token)
                ->where('used', false)
                ->where('expires_at', '>', now())
                ->lockForUpdate()
                ->first();

            if (!$scanToken) {
                DB::rollBack();
                Log::warning('Token invalide lors du store', [
                    'token' => $request->token,
                    'ip'    => $request->ip(),
                ]);
                return redirect()->route('ticket.scan')
                    ->with('error', 'Token invalide ou déjà utilisé.');
            }

            $scanToken->update(['used' => true]);

            $lastNumero = Ticket::where('service_id', $request->service_id)
                ->lockForUpdate()
                ->max('numero');

            $ticket = Ticket::create([
                'service_id' => $request->service_id,
                'numero'     => ((int) $lastNumero) + 1,
                'statut'     => Ticket::EN_ATTENTE,
                'ip_address' => $request->ip(),
            ]);

            DB::commit();

            event(new TicketCreated($ticket->load('service')));

            Log::info('Ticket créé', ['ticket_id' => $ticket->id]);

            return redirect()->route('ticket.show', $ticket->id);
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Erreur création ticket', ['message' => $e->getMessage()]);
            throw $e;
        }
    }

    public function show(Ticket $ticket, Request $request)
    {
        return response()
            ->view('ticket.show', compact('ticket'))
            ->header('Cache-Control', 'no-store, no-cache, must-revalidate')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }

    public function truncate()
    {
        DB::table('tickets')->truncate();
        Log::warning('Table tickets vidée');

        return redirect()->back()
            ->with('success', 'La table des tickets a été vidée avec succès.');
    }
}
