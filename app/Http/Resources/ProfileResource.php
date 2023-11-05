<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\UniversityResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'name' =>  $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'speciality_id' => $this->speciality_id,
            'group_id' => $this->group_id,
            'university' => UniversityResource::make($this?->university),
            'image' =>  $this->image ? env('APP_URL') .  Storage::url('users/' . $this->image) : '',
        ];
    }
}
