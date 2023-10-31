<?php

namespace App\Http\Requests\Board\Settings;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSettingsRequest extends FormRequest
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
            'email' => 'required|email' , 
            'mobile' => 'required' , 
            'whatsup' => 'required|url' , 
            'facebook' => 'required|url' , 
            'telegram' => 'required|url' , 
            'instagram' => 'required|url' , 
            'twitter' => 'required|url' , 
            'about_ar' => 'required' , 
            'about_en' => 'required' , 
            'terms_ar' => 'required' , 
            'terms_en' => 'required' , 
            'privacy_ar' => 'required' , 
            'privacy_en' => 'required' , 
        ];
    }
}
