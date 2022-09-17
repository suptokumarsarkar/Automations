<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Logic\Helpers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class FacebookAuth extends Controller
{
    public function login(Request $request)
    {
        $facebookId = $request->userId;
        $user = User::where("facebookId", $facebookId)->first();
        if (!$user) {
            $user = new User;
            $user->name = $request->profile_name;
            $user->email = $request->profile_email;
            $user->password = Hash::make(rand());
            $user->facebookId = $facebookId;
            $user->email_verified_at = time();
            $extra_data = [
                'profile' => $request->profile_picture
            ];
            $user->user_data = json_encode($extra_data, 1);
            $user->save();
        }
        if (Auth::loginUsingId($user->id, false)) {
            return new Response([
                [
                    'status' => 200,
                    'message' => Helpers::translate('Login Success'),
                    'RememberToken' => $user->getRememberToken(),
                    'id' => $user->id,
                    'user' => $user,
                ]
            ]);
        } else {
            return new Response([
                [
                    'status' => 400,
                    'message' => Helpers::translate('Login Failed'),
                ], 400
            ]);
        }
    }
}
