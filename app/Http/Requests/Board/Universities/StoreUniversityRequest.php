<?php

namespace App\Http\Requests\Board\Universities;

use Illuminate\Foundation\Http\FormRequest;

class StoreUniversityRequest extends FormRequest
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
            'rate' => 'required' , 
            'title_en' => 'required' , 
            'content_ar' => 'required' , 
            'content_en' => 'required' , 
            'cover' => 'required|image' , 
            'image' => 'required|image' , 
            'country_id' => 'required' , 
        ];
    }
}
