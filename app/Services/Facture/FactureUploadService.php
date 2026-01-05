<?php

namespace App\Services\Facture;

use Illuminate\Http\Request;

use App\Services\Upload\DocumentUploadService;

class FactureUploadService
{
    public function __construct(
        private DocumentUploadService $uploader
    ) {}

    public function upload(Request $request): array
    {
        return [
            'facture' => $this->uploader->upload(
                $request,
                'facture',
                'facture',
                ['required', 'file', 'mimes:pdf', 'max:2048']
            )
        ];
    }
}

