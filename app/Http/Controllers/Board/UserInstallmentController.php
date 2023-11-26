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
        return view('board.user_installments.index');
    }

   

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(UserInstallments $installment)
    {
        $installment->load(['user' , 'course' , 'purchase' , 'transaction' ]);
        return view('board.user_installments.show' , compact('installment') );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
