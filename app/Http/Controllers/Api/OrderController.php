<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Http\Resources\Api\OrderResource;
class OrderController extends Controller
{

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {


        return response()->json([
            'status' => true,
            'message' => 'success',
            'data' =>  [
                'order' => new OrderResource($order) , 
            ]
        ] , 200);        


    }


}
