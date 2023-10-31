<?php

namespace App\Http\Requests\Board\Admins;

use Illuminate\Foundation\Http\FormRequest;
use Request;
class UpdateAdminRequest extends FormRequest
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
        $id = Request::segment(3);
        return [
            'name' => 'required' , 
            'password' => 'nullable|confirmed' , 
            'email' => 'required|email|unique:users,email,'.$id , 
            'phone' => 'nullable|unique:users,phone,'.$id , 
            'image' => 'nullable|image' , 
            'active' => 'nullable'
        ];
    }
}
