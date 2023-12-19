<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function items()
    {
        return $this->hasMany(PurchaseItem::class);
    }


    // payment types
    const ONE_LATER_INSTALLMENT = 'one_later_installment';
    const INSTALLMENTS = 'installments';
    const TOTAL_AMOUNT = 'total_amount';


    // payment methods 

}
