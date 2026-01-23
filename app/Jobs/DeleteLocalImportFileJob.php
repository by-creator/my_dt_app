<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class DeleteLocalImportFileJob implements ShouldQueue
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
        Storage::disk('local')->delete($this->path);

        Log::info('🧹 Fichier XLSX local supprimé', [
            'path' => $this->path,
        ]);
    }
}
