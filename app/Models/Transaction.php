<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{

    protected $casts = [
        'payment_date' => 'datetime' , 

    ];
    use HasFactory;

    // payment methods
    const BANK_TRANSFER = 'bank_transfer';
    const MY_FATOORAH = 'my_fatoorah';
    const BANK_MISR  = 'bank_misr';


    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function purchase()
    {
        return $this->belongsTo(Purchase::class);
    }


    public function installment()
    {
        return $this->belongsTo(UserInstallments::class , 'installment_id' );
    }
}
