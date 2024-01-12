<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\BasicCourseResource;
class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'order_number' => $this->order_number , 
            'amount' => $this->amount , 
            'is_paid' => $this->is_paid == 1 ? true : false , 
            'payment_type' => $this->payment_type , 
            'payment_method' => $this->payment_method , 
            'course' => new BasicCourseResource($this->course) , 
        ];
    }
}
