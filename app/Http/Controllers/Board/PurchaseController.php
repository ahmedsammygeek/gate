<?php

namespace App\Http\Controllers\Board;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Purchase;
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
        return view('board.purchases.transactions' , compact('purchase') );
    }

    public function show(Purchase $purchase)
    {
        $this->authorize('purchases.show');
        $purchase->load(['user' , 'items.course' ]);
        return view('board.purchases.show' , compact('purchase') );
    }

    public function transaction(Purchase $purchase)
    {
        $this->authorize('purchases.show');
        $purchase->load(['user' , 'items.course' , 'directTransaction' ]);
        return view('board.purchases.transaction' , compact('purchase') );
    }

}
