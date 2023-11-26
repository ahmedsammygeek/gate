<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use App\Http\Resources\BasicDataResource;
use App\Http\Resources\UniversityResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Storage;
class UserResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'name' =>  $this?->name,
            'image' =>  Storage::url('users/' . $this->image) ,
        ];
    }
}
