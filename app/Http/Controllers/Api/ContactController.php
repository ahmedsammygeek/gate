<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Message;
use App\Http\Requests\Api\ContactRequest;
class ContactController extends Controller
{
    

    /**
     * Store a newly created resource in storage.
     */
    public function store(ContactRequest $request)
    {
        $message = new Message;
        $message->name = $request->name;
        $message->email = $request->email;
        $message->message = $request->message;
        $message->save();

        return response()->json([
            'status' => true,
            'message' => 'message send successfully',
            'data' => [] , 
        ]);
    }

}
