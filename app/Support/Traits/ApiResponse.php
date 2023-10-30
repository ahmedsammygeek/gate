<?php

namespace App\Support\Traits;


trait ApiResponse
{
    public function success(bool $status = true, string  $message = "success", mixed $data = null)
    {
        return response()->json(["success"=> $status,"message"=> $message,"data"=> $data]);
    }
}
