<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Logic\Helpers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class MicrosoftAuth extends Controller
{
    public function login(Request $request)
    {
        $microsoftId = $request->userId;
        $user = User::where("microsoftId", $microsoftId)->first();
        if (!$user) {
            $user = new User;
            $user->name = $request->profile_name;
            $user->email = $request->profile_email;
            $user->password = Hash::make(rand());
            $user->microsoftId = $microsoftId;
            $user->email_verified_at = time();
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
