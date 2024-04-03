<?php

namespace App\Http\Requests\Board\TrainerTransfers;

use Illuminate\Foundation\Http\FormRequest;

class StoreTrainerTransferRequest extends FormRequest
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
            'trainer_id' => 'required' , 
            'course_id' => 'required' , 
            'transfer_type' => 'required' , 
            'amount' => 'required' , 
            'image' => 'nullable|file' ,
            'comments' => 'nullable' ,  
        ];
    }
}
