<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SendFactureDocumentsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'facture.*' => 'nullable|mimes:pdf|max:2048',
        ];
    }
}
