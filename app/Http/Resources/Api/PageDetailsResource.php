<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PageDetailsResource extends JsonResource
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
            'slug' => $this->getTranslations('slug', ['ar', 'en']),
            'content' => $this->getTranslations('content', ['ar', 'en']),

        ];
    }
}
