<?php

namespace App\Http\Resources\Api\Settings;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SocialResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'facebook' => $this->facebook ,
            'instagram' => $this->instagram ,
            'youtube' => $this->youtube ,
            'twitter' => $this->twitter ,
            'email' => $this->email ,
            'phone' => $this->phone ,
            'youtube_video_link' => $this->youtube_video_link ,
            'footer_text' => $this->getTranslations('footer_text', ['ar', 'en']),
            'address' => $this->getTranslations('address', ['ar', 'en']),

        ];
    }
}
