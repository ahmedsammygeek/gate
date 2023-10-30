<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BasicCourseResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'title' => $this->title,
            'subtitle' => $this->subtitle,
            'image' => $this->image,
            'price' => $this->price,
            'price_after_discount' => $this->price_after_discount,
            'reviews' => $this->reviews,
          //  'reviews_count' => $this->reviews_count,
            'trainer' => BasicUserResource::make($this->trainer),
            'category' => BasicDataResource::make($this->category),
        ];
    }
}
