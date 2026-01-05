<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'role_id'   => 'required|exists:roles,id',
            'name'      => 'required|string|max:255',
            'telephone' => 'nullable|string|max:50',
            'email'     => 'required|email',
            'password'  => 'nullable|min:6',
        ];
    }
}
