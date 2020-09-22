<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    //
    public function newMethod(){

        return response()->json([
            'msg' => " Json Response Successful "
        ]);
    }

    public function tag(){
        return response()->json([
            'msg' => 'Some Err Occured'
        ], 422);
    }
}
