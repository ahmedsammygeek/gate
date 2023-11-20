<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Resources\Json\JsonResource;

class BasicCourseResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->getTranslations('title', ['ar', 'en']),
            'subtitle' => $this->getTranslations('subtitle', ['ar', 'en']),
            'image' =>  Storage::url('courses/' . $this->image),
            'price' => $this->getPrice(),
            'price_after_discount' => $this->price_after_discount,
            'reviews' => $this->reviews,
            'trainer' => BasicUserResource::make($this->trainer),
            'category' => BasicDataResource::make($this->category),
        ];
    }
}
