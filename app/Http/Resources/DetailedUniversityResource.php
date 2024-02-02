<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\BasicDataResource;
use App\Http\Resources\BasicUserResource;
use App\Http\Resources\BasicCourseResource;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Api\PackageDetailsResource;
use Carbon\Carbon;
class DetailedUniversityResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'slug' => $this->getTranslations('slug', ['ar', 'en']) , 
            'title' => $this->getTranslations('title', ['ar', 'en']),
            'content' => $this->getTranslations('content', ['ar', 'en']),
            'image' =>Storage::url('universities/' . $this->image),
            'cover' =>Storage::url('universities/' . $this->cover),
            'rate' => $this->rate,
            'country' => BasicDataResource::make($this->country),
            'trainer' => BasicUserResource::make($this->trainer),
            'courses' => BasicCourseResource::collection($this->courses()->where('type' , 1 )->where('is_active' , 1 )->whereDate('ends_at'  , '>' , Carbon::today() )->get()),
            'packages' => PackageDetailsResource::collection($this->courses()->where('type' , 2 )->where('is_active' , 1 )->whereDate('ends_at'  , '>' , Carbon::today() )->get()),
        ];
    }
}
