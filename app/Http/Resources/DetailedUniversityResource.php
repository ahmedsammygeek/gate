<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use App\Http\Resources\BasicDataResource;
use App\Http\Resources\BasicCourseResource;
use Illuminate\Http\Resources\Json\JsonResource;

class DetailedUniversityResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'image' => $this->image,
            'cover' =>$this->cover,
            'rate' => $this->rate,
            'country' => BasicDataResource::make($this->country),
            'courses' => BasicCourseResource::collection($this->courses),
        ];
    }
}
