<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\BasicCourseResource;
class UserPurchaseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'purchase_number' => $this->purchase_number , 
            'status' => $this->purchasePayingStatusAsText()  , 
            'total' => $this->total , 
            'created_at' => $this->created_at->toDateTimeString() , 
            'course' =>   new BasicCourseResource($this->order?->course) , 
            'purchase_type' => $this->purchase_type , 
        ];
    }
}
