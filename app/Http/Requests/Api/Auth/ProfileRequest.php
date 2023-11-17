<?php

namespace App\Http\Requests\Api\Auth;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'university_id' => ['required', 'numeric', 'exists:universities,id'],
            'division' => ['nullable'],
            'study_type' => ['nullable'] , 
            'image' => ['nullable' , 'image' ] , 
        ];
    }
}
