<?php

namespace App\Http\Requests\Api\Auth;

use Illuminate\Foundation\Http\FormRequest;

class SendOtpRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'otp' =>'required' ,
        ];
    }
}
