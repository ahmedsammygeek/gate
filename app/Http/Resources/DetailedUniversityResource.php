<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\BasicDataResource;
use App\Http\Resources\BasicCourseResource;
use Illuminate\Http\Resources\Json\JsonResource;

class DetailedUniversityResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->getTranslations('title', ['ar', 'en']),
            'content' => $this->getTranslations('content', ['ar', 'en']),
            'image' =>  env('APP_URL') . Storage::url('universities/' . $this->image),
            'cover' =>  env('APP_URL') . Storage::url('universities/' . $this->cover),
            'rate' => $this->rate,
            'country' => BasicDataResource::make($this->country),
            'courses' => BasicCourseResource::collection($this->courses),
        ];
    }
}
