<?php

namespace App\Http\Controllers\Api\Apps;

use App\Http\Controllers\Controller;
use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConnectorLightNit extends Controller
{
    public function getAccounts(Request $request)
    {
        $accounts = Account::where("accountId", Auth::id())->where("type", $request->AppId)->get();
        return json_encode($accounts);
    }
}
