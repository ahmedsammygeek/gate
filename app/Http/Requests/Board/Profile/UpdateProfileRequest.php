<?php

namespace App\Http\Requests\Board\Profile;

use Illuminate\Foundation\Http\FormRequest;
use Auth;
class UpdateProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required' , 
            'email' => 'required|email|unique:users,email,'.Auth::id() , 
            'phone' => 'nullable|unique:users,phone,'.Auth::id() , 
            'password' => 'nullable|confirmed' , 
            'image' => 'nullable|image'
        ];
    }
}
