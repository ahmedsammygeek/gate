<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\BasicCourseResource;
class UserInstallmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'installment_number' => $this->installment_number , 
            'amount' => $this->amount  , 
            'due_date' => $this->due_date->toDateString() , 
            'due_date_for_human' => $this->due_date->diffForHumans() , 
            'is_paid' => $this->transaction_id ? true : false ,
            // 'purchase' => $this->purchase
            'course' => new BasicCourseResource($this->purchase?->order?->course ) , 
        ];
    }
}
