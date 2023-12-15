<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\BasicDataResource;
use Storage;
class PackageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id , 
            'created_at' => $this->created_at->toDateTimeString() , 
            'title' => $this->getTranslations('title', ['ar', 'en']),
            'price' => $this->getPrice() , 
            'category' => BasicDataResource::make($this->category) , 
            'reviews' => $this->reviews,
            'image' =>  Storage::url('courses/' . $this->image),
            'reviews_count' => $this->courseReviews->count() , 
            'courses_count' => $this->courses->count() , 
        ];
    }
}
