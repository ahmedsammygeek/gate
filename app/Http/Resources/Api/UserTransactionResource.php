<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Api\UserPurchaseResource;
class UserTransactionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'payment_id' => $this->payment_id , 
            'amount' => $this->amount , 
            'payment_date' => $this->payment_date->toDateTimeString() , 
            'payment_method' => $this->paymentMethodAsText(), 
            'purchase' => new UserPurchaseResource($this->purchase) , 
        ];
    }
}
