<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Resources\Json\JsonResource;

class TrainerResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'image' =>  Storage::url('trainers/' . $this->image),
            'telegram' => $this->telegram,
            'youtube' => $this->youtube,
            'twitter' => $this->twitter,
            'instagram' => $this->instagram,
            'facebook' => $this->facebook,
            'bio' => $this->bio,
            'job_title' => $this->job_title,
        ];
    }
}
