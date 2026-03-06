<?php

namespace App\Console\Commands;

use App\Models\ScanToken;
use Illuminate\Console\Command;

class DeleteToken extends Command
{
    protected $signature   = 'app:delete-token';
    protected $description = 'Supprimer les tokens de scan expirés';

    public function handle()
    {
        ScanToken::where('expires_at', '<', now())->delete();
    }
}
