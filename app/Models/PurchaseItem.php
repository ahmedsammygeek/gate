<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseItem extends Model
{
    use HasFactory;


    protected $fillable = ['item_id' , 'course_original_price' , 'course_purchase_price' , 'notes' , 'system_details' , 'item_type' ];

    public function course()
    {
        return $this->belongsTo(Course::class , 'item_id');
    }

    public function purchase()
    {
        return $this->belongsTo(Purchase::class , 'purchase_id');
    }
}
