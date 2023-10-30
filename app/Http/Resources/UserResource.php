<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use App\Http\Resources\BasicDataResource;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'name' =>  $this?->name,
            'email' => $this?->email,
            'phone' => $this?->phone,
            'image' => $this?->image,
            'university' => BasicDataResource::make($this->university),
            '_token' => $this->token,
        ];
    }
}
