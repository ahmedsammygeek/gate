<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Api\ReviewResource;
use App\Http\Resources\BasicDataResource;
use App\Http\Resources\Api\PackageCourseResource;
use Storage;
class PackageDetailsResource extends JsonResource
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
            'image' =>  Storage::url('courses/' . $this->image),
            'title' => $this->getTranslations('title', ['ar', 'en']),
            'subtitle' => $this->getTranslations('subtitle', ['ar', 'en']),
            'slug' => $this->getTranslations('slug', ['ar', 'en']),
            'content' => $this->getTranslations('content', ['ar', 'en']),
            'curriculum' => $this->getTranslations('curriculum', ['ar', 'en']),
            'price' => $this->getPrice() , 
            'category' => BasicDataResource::make($this->category) , 
            'reviews' => $this->reviews,
            'reviews_count' => $this->courseReviews->count() , 
            'students_number' => $this->students_number , 
            'course_reviews' => ReviewResource::collection($this->courseReviews) , 
            'package_courses' => PackageCourseResource::collection($this->courses) , 
        ];
    }
}
