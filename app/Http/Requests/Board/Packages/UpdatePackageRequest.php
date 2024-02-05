<?php

namespace App\Http\Requests\Board\Packages;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePackageRequest extends FormRequest
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
            'courses' => 'required' , 
            'ends_at' => 'required'  , 
            'image' => 'nullable|image' , 
            'university_id' => 'required' ,
            'category_id' => 'required' , 
            'title_ar' => 'required' , 
            'title_en' => 'required' , 
            'subtitle_ar' => 'required' , 
            'subtitle_en' => 'required' , 
            'content_ar' => 'required' , 
            'content_en' => 'required' , 
            'curriculum_ar' => 'required' , 
            'curriculum_en' => 'required' , 
            'price' => 'required' , 
            'price_later' => 'nullable' , 
            'price_after_discount' => 'nullable' ,
            'discount_percentage' => 'nullable', 
            'discount_end_at' => 'nullable' , 
            'show_in_home' => 'nullable' , 
            'active' => 'nullable' ,  
            'days' => 'required_with:price_later' ,  
        ];
    }
}
