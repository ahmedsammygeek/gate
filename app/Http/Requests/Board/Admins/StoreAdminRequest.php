<?php

namespace App\Http\Requests\Board\Admins;

use Illuminate\Foundation\Http\FormRequest;

class StoreAdminRequest extends FormRequest
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
            'password' => 'required|confirmed' , 
            'email' => 'required|email|unique:users,email' , 
            'phone' => 'nullable|unique:users,phone' , 
            'image' => 'nullable|image' , 
            'active' => 'nullable' , 
            'is_super_admin' => 'nullable'
        ];
    }
}
