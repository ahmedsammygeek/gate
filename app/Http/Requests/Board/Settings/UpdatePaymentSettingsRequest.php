<?php

namespace App\Http\Requests\Board\Settings;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePaymentSettingsRequest extends FormRequest
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
            'bank_logo' => 'nullable|image' , 
            'bank_name' => 'required' , 
            'bank_misr' => 'required' , 
            'my_fatoora' => 'required' , 
            'bank_transfer' => 'required' , 
            'swift_code' => 'required' , 
            'iban' => 'required' , 
        ];
    }
}
