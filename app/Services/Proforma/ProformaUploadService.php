<?php

namespace App\Services\Proforma;

use App\Services\Upload\DocumentUploadService;
use Symfony\Component\HttpFoundation\Request;

class ProformaUploadService
{
    public function __construct(
        private DocumentUploadService $uploader
    ) {}

    public function upload(Request $request): array
    {
        return [
            'proforma' => $this->uploader->upload(
                $request,
                'proforma',
                'proforma',
                ['required', 'file', 'mimes:pdf', 'max:2048']
            )
        ];
    }
}
