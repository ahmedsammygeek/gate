<?php

namespace App\Http\Requests\Board\Users;

use Illuminate\Foundation\Http\FormRequest;
use Request;
class UpdateUserRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $id = Request::segment(3);
        return [
            'name' => 'required', 
            'email' => 'required|unique:users,email,'.$id , 
            'phone' => 'required|unique:users,phone,'.$id , 
            'group_number' => 'nullable' , 
            'university_id' => 'required' , 
            'study_type' => 'nullable' , 
            'division' => 'nullable' , 
            'is_banned' => 'nullable' , 
            'telegram' => 'required' , 
        ];
    }
}
