<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;
class CourseInstallmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'amount' => $this->amount , 
            'days' => $this->days , 
            'due_date' => Carbon::today()->addDay($this->days)->toDateString() , 
        ];
    }
}
