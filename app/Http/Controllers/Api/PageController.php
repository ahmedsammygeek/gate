<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Page;
use App\Http\Resources\Api\PageResource;
use App\Http\Resources\Api\PageDetailsResource;
class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pages = Page::where('is_active' , 1 )->get();

        return response()->json([
            'status' => true,
            'message' => 'success',
            'data' =>  [
                'pages' => PageResource::collection($pages) , 
            ]
        ] , 200);
    }


    public function show($identifier)
    {
        $page = Page::where('id' , $identifier )->orWhere('slug->ar' , $identifier )->orWhere('slug->en' , $identifier )->first();

         return response()->json([
            'status' => true,
            'message' => 'success',
            'data' =>  [
                'page' => new PageDetailsResource($page) , 
            ]
        ] , 200);
    }


}
