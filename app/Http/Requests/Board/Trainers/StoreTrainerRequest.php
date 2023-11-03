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
            'facebook' => 'nullable|string',
            'youtube' => 'nullable|string' ,
            'twitter' => 'nullable|string' ,
            'instagram' => 'nullable|string' ,
            'name' => 'required' ,
            'image'=> 'required|image' ,
            'job_title' => 'required' ,
            'bio' => 'required' ,
            'show_in_home' => 'nullable' ,
        ];
    }
}
