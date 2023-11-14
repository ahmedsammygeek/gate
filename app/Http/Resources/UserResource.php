<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use App\Http\Resources\BasicDataResource;
use App\Http\Resources\UniversityResource;
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
            'group_number' => $this?->group_number,
            'university' => UniversityResource::make($this->university),
        ];
    }
}
