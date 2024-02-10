<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Banner;
use Illuminate\Support\Facades\DB;

class BannerController extends Controller
{
    
    public function api()
    {
    
        return response()->json([
            'code' => 200,
            'data'   => Banner::all(),
            'message' => 'OK'
        ], 200);

    }
}
