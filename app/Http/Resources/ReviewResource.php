<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\BasicUserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user' => BasicUserResource::make($this->whenLoaded('user')),
            'comment' => $this->comment,
            'rate' => $this->rate,
            'active' => $this->is_active
        ];
    }
}
