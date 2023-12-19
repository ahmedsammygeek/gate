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
        return view('board.purchases.index');
    }

    public function installments(Purchase $purchase)
    {
        return view('board.purchases.installments' , compact('purchase') );
    }


    public function transactions(Purchase $purchase)
    {
        return view('board.purchases.transactions' , compact('purchase') );
    }

    public function show(Purchase $purchase)
    {
        $purchase->load(['user' , 'items.course' ]);
        return view('board.purchases.show' , compact('purchase') );
    }

}
