<?php

namespace App\Http\Controllers\Api\Session;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SessionController extends Controller
{
    public function sideBar(Request $request)
    {
        $sidebar = Session::get('sidebar');
        if($sidebar ==  true)
        {
            Session::put('sidebar', false);
        }else{
            Session::put('sidebar', true);
        }
    }
}
