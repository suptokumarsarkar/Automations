<?php

namespace App\Http\Controllers\Api\V1\Auth;
ini_set('memory_limit', '-1');
use App\CentralLogics\Helpers;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CustomerAuthController extends Controller
{


    public function registration(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'f_name' => 'required'
        ]);
        
        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 403);
        }
        
        if(isset($request->email)){
            $user = User::where("email", $request->email)->first();
            $user->f_name = $request->f_name;
            $user->cm_firebase_token = $request->fcm;
            $email = $request->email;
            $user->save();
        }else{
        $temporary_token = Str::random(40);
        $email = "user".rand().rand().'@gmail.com';
        $user = User::create([
            'f_name' => $request->f_name,
            'l_name' => '',
            'email' => $email,
            'phone' => rand(),
            'password' => bcrypt($request->password),
            'temporary_token' => $temporary_token,
        ]);
        
        $user->cm_firebase_token = $request->fcm;
        $user->save();
        }
        return response()->json(['token' => $email], 200);
    }

}
