<?php

namespace App\Http\Requests\Api\Auth;

use Illuminate\Foundation\Http\FormRequest;

class ChangeWtsNumberRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'phone' => ['required', 'unique:users,phone,'. auth()->id()],
        ];
    }
}
