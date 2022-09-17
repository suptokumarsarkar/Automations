<?php

namespace App\Apps;

use App\Models\Account;
use App\Models\AppsData;
use Illuminate\Support\Facades\Auth;

class AppInfo
{
    public $app;
    /**
     * @var mixed
     */
    private $appClass;

    function __construct($AppId)
    {
        $app = AppsData::where("AppId", $AppId)->first();
        if ($app !== null) {
            $this->app = $app;
            $appClassHere = "App\\Apps\\" . $this->app->AppId;
            $this->appClass = new $appClassHere();
        } else {
            redirect()->route('apps.index')->send();
        }
    }

    public function getLogo()
    {
        return $this->app->getLogo();
    }


    public
    function getActions($trans = false)
    {
        return $this->appClass->getActions($trans);
    }

    public
    function getTriggers($trans = false)
    {
        return $this->appClass->getTrigger($trans);
    }

    public
    function getAccounts()
    {
        return Account::where("accountId", Auth::id())->where("type", $this->app->AppId)->get();
    }
}
