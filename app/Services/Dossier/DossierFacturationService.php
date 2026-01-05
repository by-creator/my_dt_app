<?php

namespace App\Services\Dossier;

use App\Models\DossierFacturation;
use Illuminate\Http\Request;

class DossierFacturationService
{
    public function store(Request $request): void
    {
        $fields = ['proforma', 'facture', 'bon'];

        $data = [
            'date_proforma' => $request->date_proforma,
        ];

        foreach ($fields as $field) {
            $data[$field] = [];

            if ($request->hasFile($field)) {
                foreach ($request->file($field) as $file) {
                    $path = $file->store("documents/$field", 'b2');

                    $data[$field][] = [
                        'original' => $file->getClientOriginalName(),
                        'path' => $path,
                    ];
                }
            }
        }

        DossierFacturation::create($data);
    }
}
