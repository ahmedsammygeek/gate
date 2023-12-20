<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LessonDetailsResource extends JsonResource
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
            'title' => $this->getTranslations('title', ['ar', 'en']),
            'description' => $this->getTranslations('description', ['ar', 'en']),
            'vimeo_number' => $this->vimeo_number , 
            'is_free' => $this->is_free == 0 ? false  : true , 
        ];
    }
}
