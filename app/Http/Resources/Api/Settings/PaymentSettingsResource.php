<?php

namespace App\Http\Resources\Api\Settings;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Storage;
class PaymentSettingsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'my_fatoora' => $this->my_fatoora == 0 ? false : true , 
            'bank_misr' => $this->bank_misr == 0 ? false : true , 
            'bank_transfer' => $this->bank_transfer == 0 ? false : true , 
            'bank_name' => $this->bank_name , 
            'swift_code' => $this->swift_code , 
            'iban' => $this->iban , 
            'bank_logo' => Storage::url('settings/'.$this->bank_logo) , 
        ];
    }
}
