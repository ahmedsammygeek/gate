<?php

namespace App\Http\Requests\Api\Auth;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'phone' => ['required', 'numeric', 'exists:users,phone'],
            'password' => ['required'],
        ];
    }
}
