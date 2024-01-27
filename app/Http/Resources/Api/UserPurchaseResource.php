<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\BasicCourseResource;
use App\Models\Setting;
use Storage;
class UserPurchaseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data =  [
            'purchase_number' => $this->purchase_number , 
            'status' => $this->purchasePayingStatusAsText()  , 
            'total' => $this->total , 
            'created_at' => $this->created_at->toDateTimeString() , 
            'course' =>   new BasicCourseResource($this->order?->course) , 
            'purchase_type' => $this->purchase_type , 
        ];

        if ($this->order?->payment_method == 3 ) {
            $settings = Setting::first();
            $data['bank_transfer_details'] = [
                'bank_name' => $settings->bank_name , 
                'iban' => $settings->iban , 
                'swift_code' => $settings->swift_code , 
                'bank_logo' => Storage::url('settings/'.$settings->bank_logo) , 
            ];
        }

        return $data;
    }
}
