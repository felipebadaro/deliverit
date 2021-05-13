<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Run as Run;

class RunController extends Controller
{
    public function store(Request $request){

        $request->validate(
            [
                'type' => 'required',
                'happened_at' => 'required|date_format:Y-m-d H:i:s',
            ]
        );

        if(Run::create($request->all())){
            return response()->json(\Config::get('constants.responses.msg_201'), 201);
        }
        else{
            return response()->json(\Config::get('constants.responses.msg_409'), 409);
        }
    }

}
