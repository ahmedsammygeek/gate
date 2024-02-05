<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class , 'user_id');
    }


    public function course()
    {
        return $this->belongsTo(Course::class , 'course_id');
    }

    public function paymentMethodAsText() {
        switch ($this->payment_method) {
            case 3:
            return 'تحويل بنكى';
            break;
            case 2:
            return 'ماى فاتوره';
            break;
            case 1:
            return 'بنك مصر';
            break;
            default:
            'لم يتم التحديد';
            break;
        }
    }

}
