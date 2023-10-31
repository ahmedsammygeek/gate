<?php

namespace App\Http\Requests\Board\Universities;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUniversityRequest extends FormRequest
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
        return [
            'title_ar' => 'required' , 
            'title_en' => 'required' , 
            'rate' => 'required' , 
            'content_ar' => 'required' , 
            'content_en' => 'required' , 
            'cover' => 'nullable|image' , 
            'image' => 'nullable|image' , 
            'country_id' => 'required' , 
        ];
    }
}
