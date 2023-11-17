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
            'division' => $this->division,
            'study_type' => $this->study_type,
            'university' => UniversityResource::make($this?->university),
            'image' =>  Storage::url('users/' . $this->image) ,
            'group_number' => $this->group_number , 
            'is_activated' => $this->activated_at ? true : false , 
        ];
    }
}
