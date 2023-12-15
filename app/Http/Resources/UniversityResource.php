<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use App\Http\Resources\MediaResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Resources\Json\JsonResource;

class UniversityResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'slug' => $this->getTranslations('title', ['ar', 'en']) , 
            'title' => $this->getTranslations('title', ['ar', 'en']),
            'image' => Storage::url('universities/' . $this->image),
            'cover' => Storage::url('universities/' . $this->cover),
            'rate' => $this->rate,
            'country' => BasicDataResource::make($this->country)
        ];
    }
}
