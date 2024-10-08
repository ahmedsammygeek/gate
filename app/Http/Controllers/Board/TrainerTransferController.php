<?php

namespace App\Http\Controllers\Board;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Board\TrainerTransfers\StoreTrainerTransferRequest;
use App\Http\Requests\Board\TrainerTransfers\UpdateTrainerTransferRequest;
use App\Models\TrainerTransfer;
use Auth;
class TrainerTransferController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('board.trainers_transfers.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('board.trainers_transfers.create' );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTrainerTransferRequest $request)
    {
        $trainer_transfer = new TrainerTransfer;
        $trainer_transfer->user_id = Auth::id();
        $trainer_transfer->amount = $request->amount;
        $trainer_transfer->course_id = $request->course_id;
        $trainer_transfer->trainer_id = $request->trainer_id;
        $trainer_transfer->transfer_type = $request->transfer_type;
        $trainer_transfer->transfer_date = $request->transfer_date;
        if ($request->image) {
            $trainer_transfer->image = basename($request->file('image')->store('trainers_transfers'));
        }
        $trainer_transfer->comments = $request->comments;
        $trainer_transfer->save();
        return redirect(route('board.trainers_transfers.index'))->with('success' , 'تم الاضافه بنجاح' );
    }

    /**
     * Display the specified resource.
     */
    public function show(TrainerTransfer $trainers_transfer)
    {
        // dd($trainers_transfer);
        return view('board.trainers_transfers.show' , compact('trainers_transfer') );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TrainerTransfer $trainers_transfer)
    {
        return view('board.trainers_transfers.edit' , compact('trainers_transfer') );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTrainerTransferRequest $request, TrainerTransfer $trainers_transfer)
    {
        $trainers_transfer->amount = $request->amount;
        $trainers_transfer->course_id = $request->course_id;
        $trainers_transfer->trainer_id = $request->trainer_id;
        $trainers_transfer->transfer_type = $request->transfer_type;
        $trainers_transfer->transfer_date = $request->transfer_date;
        if ($request->image) {
            $trainers_transfer->image = basename($request->file('image')->store('trainers_transfers'));
        }
        $trainers_transfer->comments = $request->comments;
        $trainers_transfer->save();
        return redirect(route('board.trainers_transfers.index'))->with('success' , 'تم التعديل بنجاح' );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
