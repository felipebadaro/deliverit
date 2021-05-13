<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Runner as Runner;

class RunnerController extends Controller
{
    public function store(Request $request){

        $request->validate(
            [
                'name' => 'required',
                'cpf' => 'required|size:11',
                'birth_date' => 'required|date_format:Y-m-d H:i:s',
            ]
        );

        //check if is under age
        if (!Runner::isUnderAge($request->birth_date)) {

            if(Runner::create($request->all())){
                return response()->json(\Config::get('constants.responses.msg_201'), 201);
            }
            else{
                return response()->json(\Config::get('constants.responses.msg_409'), 409);
            }
        }
        else{
                return response()->json(\Config::get('constants.responses.msg_409'), 409);
        }
    }
}
