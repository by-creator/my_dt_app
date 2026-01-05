<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SendProformaDocumentsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'proforma.*' => 'nullable|mimes:pdf|max:2048',
        ];
    }
}
