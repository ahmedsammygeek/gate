<?php

namespace App\Http\Requests\Api\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:7'],
            'email' => ['required', 'email', 'unique:users,email'],
            'phone' => ['required', 'string', 'unique:users,phone',],
            'password' => ['required', 'string'],
            'telegram' => ['nullable', 'string'],
            'university_id' => ['required', 'numeric', 'exists:universities,id'],
            'speciality_id' => ['required', 'numeric'],
        ];
    }
}
