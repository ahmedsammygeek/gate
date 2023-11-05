<?php

namespace App\Http\Requests\Api\Auth;

use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'password' => ['required'],
            'new_password' => ['required', 'string', 'min:8'],
        ];
    }
}
