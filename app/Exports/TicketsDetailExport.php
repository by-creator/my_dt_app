<?php

namespace App\Exports;

use App\Models\Ticket;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class TicketsDetailExport implements FromCollection, WithHeadings, WithMapping
{
    protected Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function collection()
    {
        return Ticket::with('agent')
            ->whereNotNull('appel_at')
            ->whereNotNull('termine_at')
            ->when($this->request->agent_id, fn($q) => $q->where('agent_id', $this->request->agent_id))
            ->when($this->request->statut,   fn($q) => $q->where('statut', $this->request->statut))
            ->when($this->request->date,     fn($q) => $q->whereDate('appel_at', $this->request->date))
            ->orderByDesc('appel_at')
            ->get();
    }

    public function headings(): array
    {
        return [
            'Ticket',
            'Guichet',
            'Infos du guichet',
            'Temps attente',
            'Heure appel',
            'Heure fin',
            'Durée traitement',
            'Statut final',
        ];
    }

    public function map($ticket): array
    {
        $attente = ($ticket->created_at && $ticket->appel_at)
            ? Carbon::parse($ticket->created_at)->diff($ticket->appel_at)->format('%H:%I:%S')
            : '00:00:00';

        $traitement = ($ticket->appel_at && $ticket->termine_at)
            ? Carbon::parse($ticket->appel_at)->diff($ticket->termine_at)->format('%H:%I:%S')
            : '00:00:00';

        return [
            $ticket->code,
            $ticket->agent->name ?? '—',
            $ticket->agent->info ?? '—',
            $attente,
            optional($ticket->appel_at)->format('H:i:s') ?? '—',
            optional($ticket->termine_at)->format('H:i:s') ?? '—',
            $traitement,
            ucfirst($ticket->statut ?? '—'),
        ];
    }
}
