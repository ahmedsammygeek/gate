<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Storage;
class PackageCourseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->subCourse->id , 
            'title' => $this->subCourse->getTranslations('title', ['ar', 'en']),
            'subtitle' => $this->subCourse->getTranslations('subtitle', ['ar', 'en']),
            'image' =>  Storage::url('courses/' . $this->subCourse->image),
        ];
    }
}
