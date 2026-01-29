<?php

namespace App\Console\Commands;

use App\Services\Audit\AuditExportB2Service;
use Illuminate\Console\Command;

class AuditDailyB2Archive extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'audit:b2-archive';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(AuditExportB2Service $service)
    {
        $yesterday = now()->subDay()->toDateString();

        $service->storeAndClean($yesterday, $yesterday);

        $this->info('Audit journalier archivé et nettoyé.');
    }
}
