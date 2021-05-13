<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subscription as Subscription;

class SubscriptionController extends Controller
{
    public function store(Request $request){

        $request->validate(
            [
                'run_id' => 'exists:runs,id',
                'runner_id' => 'exists:runners,id'

            ]
        );

        if(Subscription::isPossible($request->run_id, $request->runner_id)){
            if(Subscription::create($request->all())){
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
