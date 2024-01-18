<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\BasicCourseResource;
use App\Models\Purchase;
use App\Http\Resources\Api\CourseInstallmentResource;
use App\Http\Resources\Api\UserInstallmentResource;
use Carbon\Carbon;
class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = [
            'order_number' => $this->order_number , 
            'amount' => $this->amount , 
            'amount_due_today' => $this->amount_due_today , 
            'is_paid' => $this->is_paid == 1 ? true : false , 
            'payment_type' => $this->payment_type , 
            'payment_method' => $this->payment_method , 
            'course' => new BasicCourseResource($this->course) , 
        ];
        if ($this->is_paid == 1 ) {
            switch ($this->payment_type) {
                case 'installments':
                case 'one_later_installment':
                $purchase = Purchase::where('order_id' , $this->id )->first();
                if ($purchase) {
                    $data['installments'] = UserInstallmentResource::collection($purchase->installments);
                }
                break;                
            }
        } else {
            switch ($this->payment_type) {
                case 'installments':
                $data['installments'] = CourseInstallmentResource::collection($this->course->installments()->orderBy('days' , 'ASC' )->get());
                break;
                case 'one_later_installment':
                $data['installments'] = [
                    'amount' => $this->course->price_later , 
                    'due_date' => $this->course->days , 
                    'due_date' => Carbon::today()->addDay($this->course->days)->toDateString() , 
                ];
                break;
            }
        }



        return $data;
    }
}
