<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDossierFacturationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'proforma.*' => 'nullable|mimes:pdf|max:2048',
            'facture.*'  => 'nullable|mimes:pdf|max:2048',
            'bon.*'      => 'nullable|mimes:pdf|max:2048',
            'date_proforma' => 'nullable|date',
        ];
    }
}
