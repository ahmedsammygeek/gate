<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Resources\Json\JsonResource;

class CourseUnitResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            // 'id' => $this->id,
            // 'title' => $this->getTranslations('title', ['ar', 'en']),
            'title' => $this->title,
            'active' => boolean($this->is_active),
        ];
    }
}
