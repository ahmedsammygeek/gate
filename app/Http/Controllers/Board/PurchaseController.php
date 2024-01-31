<?php

namespace App\Http\Controllers\Board;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Purchase;
use App\Models\Transaction;
class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('purchases.list');
        return view('board.purchases.index');
    }

    public function installments(Purchase $purchase)
    {
        $this->authorize('purchases.show');
        return view('board.purchases.installments' , compact('purchase') );
    }


    public function transactions(Purchase $purchase)
    {
        $this->authorize('purchases.show');
        $transactions = Transaction::where('purchase_id' , $purchase->id )->latest()->get();
        return view('board.purchases.transactions' , compact('purchase' , 'transactions' ) );
    }

    public function show(Purchase $purchase)
    {
        $this->authorize('purchases.show');
        $purchase->load(['user' , 'items.course' ]);
        return view('board.purchases.show' , compact('purchase') );
    }

    // public function transaction(Purchase $purchase)
    // {
    //     $this->authorize('purchases.show');
    //     $purchase->load(['user' , 'items.course' , 'directTransaction' ]);
    //     return view('board.purchases.transaction' , compact('purchase') );
    // }

}
