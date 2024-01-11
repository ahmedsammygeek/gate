<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
class CheckoutStep2Request extends FormRequest
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
            'course_id' => 'required' , 
            'payment_type' => [
                'required' , 
                Rule::in(['one_payment', 'one_later_installment' , 'installments' ]),
            ] , 
            'payment_method' => [
                'required_if:payment_type,installments,one_payment' , 
                Rule::in([1, 2 , 3 ]),
            ]
        ];
    }
}
