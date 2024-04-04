<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainerTransfer extends Model
{
    use HasFactory;



    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function trainer()
    {
        return $this->belongsTo(User::class , 'trainer_id' );
    }

    public function course()
    {
        return $this->belongsTo(Course::class , 'course_id' );
    }

    public function transferTypeAsText()
    {
        switch ($this->transfer_type) {
            case 1:
                return 'تحويل بنكى';
            break;
            case 2:
                return 'paypal';
            break;
            case 3:
                return 'فودافون كاش';
            break;
        }
    }


}
