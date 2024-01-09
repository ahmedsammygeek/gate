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
            'youtube' => 'required|url' , 
            'facebook' => 'required|url' , 
            'youtube_video_link' => 'required|url' , 
            'instagram' => 'required|url' , 
            'twitter' => 'required|url' , 
            'footer_text_ar' => 'required' , 
            'footer_text_en' => 'required' , 
        ];
    }
}
