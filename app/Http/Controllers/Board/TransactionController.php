<?php

namespace App\Http\Controllers\Board;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;
class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('transactions.list');
        return view('board.transactions.index');
    }

  

    /**
     * Display the specified resource.
     */
    public function show(Transaction $transaction)
    {
        $this->authorize('transactions.show');
        $transaction->load(['user' , 'purchase' , 'installment' ]);
        return view('board.transactions.show' , compact('transaction') );
    }

}
