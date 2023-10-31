<?php

namespace App\Http\Requests\Board\Trainers;

use Illuminate\Foundation\Http\FormRequest;

class StoreTrainerRequest extends FormRequest
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
            'facebook' => 'nullable|url' ,
            'youtube' => 'nullable|url' ,
            'twitter' => 'nullable|url' ,
            'instagram' => 'nullable|url' ,
            'name' => 'required' , 
            'image'=> 'required|image' , 
            'job_title' => 'required' ,
            'bio' => 'required' , 
            'show_in_home' => 'nullable' , 
        ];
    }
}
