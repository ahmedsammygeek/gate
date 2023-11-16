<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use App\Http\Resources\ReviewResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Resources\Json\JsonResource;

class DetailedCourseResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->getTranslations('title', ['ar', 'en']),
            'subtitle' => $this->getTranslations('subtitle', ['ar', 'en']),
            'curriculum' => $this->getTranslations('curriculum', ['ar', 'en']),
            'image' =>  Storage::url('courses/' . $this->image),
            'price' => $this->price,
            'price_after_discount' => $this->price_after_discount,
            'reviews' => $this->reviews,
            'trainer' => TrainerResource::make($this->whenLoaded('trainer')),
            'category' => BasicDataResource::make($this->whenLoaded('category')),
            'units' => CourseUnitResource::collection($this->whenLoaded('units')),
            'course_reviews' => ReviewResource::collection($this->whenLoaded('courseReviews')),
        ];
    }
}
