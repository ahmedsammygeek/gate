<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserInstallments extends Model
{

    protected $casts = [
        'due_date' => 'date',
    ];

    protected $fillable = ['user_id' , 'installment_number' , 'course_id' , 'amount' , 'due_date' , 'status' , 'purchase_id'];

    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function purchase()
    {
        return $this->belongsTo(Purchase::class);
    }

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    
}
