<?php

namespace App\Services\Bon;

use Illuminate\Http\Request;
use App\Services\Upload\DocumentUploadService;


class BonUploadService
{
    public function __construct(
        private DocumentUploadService $uploader
    ) {}

    public function upload(Request $request, array $fields): array
    {
        $data = [];

        foreach ($fields as $field) {
            $data[$field] = $this->uploader->upload(
                $request,
                $field,              // bon
                $field,              // dossier/bon
                ['required', 'file', 'mimes:pdf', 'max:2048']
            );
        }

        return $data;
    }
}
