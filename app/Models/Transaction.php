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


    public function paymentMethodAsText() {



        switch ($this->payment_method) {
            case Transaction::BANK_TRANSFER:
            return 'تحويل بنكى';
            break;
            case Transaction::MY_FATOORAH:
            return 'ماى فاتوره';
            break;
            case Transaction::BANK_MISR:
            return 'بنك مصر';
            break;
        }
    }

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
