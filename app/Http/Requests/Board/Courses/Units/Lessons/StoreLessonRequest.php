<?php

namespace App\Http\Requests\Board\Courses\Units\Lessons;

use Illuminate\Foundation\Http\FormRequest;

class StoreLessonRequest extends FormRequest
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
            'description_ar' => 'required' , 
            'description_en' => 'required' ,
            'is_active' => 'nullable' , 
            'video' => 'required' ,  
            'files' => 'nullable' , 
            'files.*' => 'mimes:jpg,png,zip,rar,pdf,doc,docx,jpeg',
        ];
    }
}
