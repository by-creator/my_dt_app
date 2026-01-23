<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;


class ConsolidateInfosFacturationJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        protected string $path
    ) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Log::info('🚀 Début consolidation facturation');

        // 🔥 consolidation SQL ici

        // 🧹 supprimer le fichier B2 après import
        Storage::disk('b2')->delete($this->path);

        Log::info('✅ Consolidation facturation terminée + fichier supprimé');
    }
}
