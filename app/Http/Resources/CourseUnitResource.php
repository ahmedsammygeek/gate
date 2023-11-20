<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Api\CourseUnitLessonResource;
class CourseUnitResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->getTranslations('title', ['ar', 'en']),
            'lessons' => CourseUnitLessonResource::collection($this->lessons) , 
        ];
    }
}
