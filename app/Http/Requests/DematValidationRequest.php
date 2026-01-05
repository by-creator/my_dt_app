<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DematValidationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'prenom' => 'required|string|max:255',
            'nom' => 'required|string|max:255',
            'email' => 'required|email',
            'bl' => 'required|string',
            'compte' => 'required|string',
            'documents.*' => 'file|max:20480', // 20 Mo
        ];
    }
}
