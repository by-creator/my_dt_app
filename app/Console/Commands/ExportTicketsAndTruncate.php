<?php

namespace App\Console\Commands;

use App\Exports\TicketsDetailExport;
use App\Mail\TicketsExportMail;
use App\Models\Ticket;
use Illuminate\Console\Command;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;

class ExportTicketsAndTruncate extends Command
{
    protected $signature   = 'tickets:export-and-truncate';
    protected $description = 'Export des tickets, envoi par mail puis purge de la table';

    public function handle()
    {
        $yesterday   = now()->subDay();
        $sqlDate     = $yesterday->format('Y-m-d');
        $displayDate = $yesterday->format('d-m-Y');

        $fileName = "tickets_{$displayDate}.xlsx";
        $filePath = "exports/{$fileName}";
        $fullPath = Storage::disk('local')->path($filePath);

        $to = ['aliounebadara.sy@dakar-terminal.com'];
        $cc = [
            'moussa.thiaw@dakar-terminal.com',
            'cheikh.aw@dakar-terminal.com',
            'marc.bongoyeba@dakar-terminal.com',
        ];

        Storage::disk('local')->makeDirectory('exports');

        $ticketCount = Ticket::whereNotNull('appel_at')
            ->whereNotNull('termine_at')
            ->count();

        if ($ticketCount === 0) {
            $this->warn('Aucun ticket à exporter');
            return Command::SUCCESS;
        }

        $this->info("Tickets à exporter : {$ticketCount}");

        $request = new Request(['date' => $sqlDate]);
        $stored  = Excel::store(new TicketsDetailExport($request), $filePath, 'local');

        if (!$stored || !file_exists($fullPath)) {
            $this->error("Export non généré : {$fullPath}");
            return Command::FAILURE;
        }

        try {
            Mail::to($to)
                ->cc($cc)
                ->send((new TicketsExportMail($displayDate))->attach($fullPath));

            Storage::disk('local')->delete($filePath);
            Ticket::truncate();

            $this->info('Mail envoyé, fichier supprimé, table tickets vidée.');
            return Command::SUCCESS;
        } catch (TransportExceptionInterface $e) {
            $this->error('Échec de l\'envoi du mail : ' . $e->getMessage());
            return Command::FAILURE;
        }
    }
}
