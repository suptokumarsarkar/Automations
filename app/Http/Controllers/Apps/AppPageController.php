<?php

namespace App\Http\Controllers\Apps;

use App\Apps\AppInfo;
use App\Http\Controllers\Controller;
use App\Logic\Helpers;
use App\Logic\Notification;
use App\Models\AppsData;
use App\Models\Zap;

class AppPageController extends Controller
{
    public function index()
    {
        return view("App.Apps");
    }

    public function zaps()
    {
        return view("App.Pages.Zaps");
    }

    public function zapsDetails($id, $data)
    {
        $zap = Zap::find($id);
        if ($zap) {
            return view("App.Pages.ZapsDetails", compact('zap', 'data'));
        }
        return redirect()->route('home');
    }

    public function oneAppSelected($first)
    {
        if ($apps = AppsData::where('AppId', $first)->first()) {
            return view('App.Apps', compact('apps'));
        }
        Notification::setNotification(Helpers::translate('Your AppId is not Valid'), Helpers::translate('Please try another App'), 'warning', 'bottom');
        return redirect()->route('Apps.index');
    }

    public function twoAppsSelected($first, $second)
    {
        if (!AppsData::where('AppId', $first)->first()) {
            Notification::setNotification(Helpers::translate('Your AppId is not Valid'), Helpers::translate('Please try another App'), 'warning', 'bottom');
            return redirect()->route('Apps.index');
        }
        if (!AppsData::where('AppId', $second)->first()) {
            Notification::setNotification(Helpers::translate('Your AppId is not Valid'), Helpers::translate('Please try another App'), 'warning', 'bottom');
            return redirect()->route('Apps.index');
        }
        $firstApp = new AppInfo($first);
        $secondApp = new AppInfo($second);

        return view("App.Connect", compact('firstApp', 'secondApp'));

    }
}
