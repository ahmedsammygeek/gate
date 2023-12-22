<?php

namespace App\Http\Controllers\Board;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserInstallments;
class UserInstallmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('installments.list');
        return view('board.user_installments.index');
    }

   

    /**
     * Display the specified resource.
     */
    public function show(UserInstallments $installment)
    {
        $this->authorize('installments.show');

        $installment->load(['user' , 'course' , 'purchase' , 'transaction' ]);
        return view('board.user_installments.show' , compact('installment') );
    }


}
