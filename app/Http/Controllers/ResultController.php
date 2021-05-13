<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Result as Result;
use App\Models\Run as Run;

class ResultController extends Controller
{
    public function store(Request $request){

        $validator = $request->validate(
            [
                'run_id' => 'required|exists:runs,id',
                'runner_id' => 'required|exists:runners,id',
                'begin_at' => 'required|date_format:Y-m-d H:i:s|after_or_equal:'.Run::findOrFail($request->run_id)->happened_at,
                'end_at' => 'required|date_format:Y-m-d H:i:s|after_or_equal:'.Run::findOrFail($request->run_id)->happened_at,
            ]
        );

        if ($validator->fails()) {
            return response()->json($validator->messages(), Response::HTTP_BAD_REQUEST);
        }

        //avoid same results
        if(!Result::where(['run_id' => $request->run_id, 'runner_id' => $request->runner_id])->first()){
            if(Result::create($request->all())){
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


    public function generalResult($run_id){

        $results = Result::generalResult($run_id);

        if($results){
            return response()->json($results, 200);
        }
        else{
            return response()->json(\Config::get('constants.responses.msg_200_empty'), 200);
        }
    }


    public function perAgeResult($run_id){

        $results = Result::perAgeResult($run_id);

        if($results){
            return response()->json($results, 200);
        }
        else{
            return response()->json(\Config::get('constants.responses.msg_200_empty'), 200);
        }
    }
}
