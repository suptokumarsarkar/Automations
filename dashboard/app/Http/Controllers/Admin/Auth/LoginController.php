<?php

namespace App\Http\Controllers\Admin\Auth;

use App\CentralLogics\helpers;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Gregwar\Captcha\CaptchaBuilder;
use Gregwar\Captcha\PhraseBuilder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest:admin', ['except' => ['logout']]);
    }



    public function login()
    {
        return view('admin-views.auth.login');
    }

    public function submit(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);


        if(Session::has('default_captcha_code')) {
            Session::forget('default_captcha_code');
        }
        //end recaptcha validation
        if (auth('admin')->attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {
            if(auth()->guard('admin')->user()->status == 0){
                auth()->guard('admin')->logout();
                return redirect()->back()->withInput($request->only('email', 'remember'))
                    ->withErrors(['Account Is Disabled.']);
            }
            return redirect()->route('admin.dashboard');
        }

        return redirect()->back()->withInput($request->only('email', 'remember'))
            ->withErrors(['Credentials does not match.']);
    }

    public function logout(Request $request)
    {
        auth()->guard('admin')->logout();
        return redirect()->route('admin.auth.login');
    }
}
