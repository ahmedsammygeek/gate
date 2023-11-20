<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Storage;
class ReviewResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'rate' => $this->rate , 
            'comment' => $this->comment , 
            'user' => [
                'name' => $this->user?->name , 
                'job_title' => $this->user?->job_title , 
                'image' => Storage::url('users/'.$this->user?->image), 
            ] , 
        ];
    }
}
