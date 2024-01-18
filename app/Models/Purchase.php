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



    public function installments()
    {
        return $this->hasMany(UserInstallments::class , 'purchase_id');
    }

    public function order() {

        return $this->belongsTo(Order::class);
    }

    public function directTransaction()
    {
        return $this->hasOne(Transaction::class , 'purchase_id')->where('user_installment_id' , null )->orderBy('created_at' , 'ASC' );
    }

    // public function transaction()
    // {
    //     return $this->
    // }

    public function items()
    {
        return $this->hasMany(PurchaseItem::class);
    }

    public function purchaseTypeAsText()
    {
        switch ($this->purchase_type) {
            case 'one_later_installment':
            return 'دفه واحده مؤجله';
            break;
            case 'installments':
            return 'اقساط';
            break;
            case 'total_amount':
            return 'دفع المبلغ كامل';
            break;
            break;
        }
    }


    public function purchasePayingStatusAsText()
    {
        switch ($this->is_paid) {
            case 0:
            return 'لم يتم الدفع';
            break;
            case 1:
            return 'تم الدفع بشكل جزئى';
            break;
            case 2:
            return 'تم الدفع بشكل كامل';
            break;
            break;
        }
    }



    public function purchaseItemsAsText()
    {
        // $this->load(['items.course']);
        $courses_names = [];
        // we need first to get the purchases items
        foreach ($this->items as $purchase_item) {
            $courses_names[] = $purchase_item->course?->title ; 
        } 

        return implode(' - ', $courses_names);
    }

    // payment types
    const ONE_LATER_INSTALLMENT = 'one_later_installment';
    const INSTALLMENTS = 'installments';
    const TOTAL_AMOUNT = 'total_amount';
    // payment methods 

}
