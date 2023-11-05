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
            'title' => $this->getTranslations('title', ['ar', 'en']),
            'image' => env('APP_URL') . Storage::url('universities/' . $this->image),
            'cover' => env('APP_URL') . Storage::url('universities/' . $this->cover),
            'rate' => $this->rate,
            'country' => BasicDataResource::make($this->country)
        ];
    }
}
