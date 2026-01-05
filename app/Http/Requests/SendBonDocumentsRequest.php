<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SendBonDocumentsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'bon.*' => 'nullable|mimes:pdf|max:2048',
        ];
    }
}
