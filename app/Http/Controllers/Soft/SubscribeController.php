<?php

namespace App\Http\Controllers\Soft;

use App\Http\Controllers\Controller;
use App\Logic\Helpers;
use App\Logic\Notification;
use App\Models\Subscription;
use Illuminate\Http\Request;

class SubscribeController extends Controller
{
    public function save(Request $request)
    {
        $subscription = Subscription::where("email", $request->email)->first();
        if (!$subscription) {
            $subscription = new Subscription;
            $subscription->email = $request->email;
            $subscription->type = $request->type;
            if ($subscription->save()) {
                Notification::setNotification('Success', Helpers::translate("Your Email Added To Subscription List."), 'success', 'bottom');
            } else {
                Notification::setNotification('Failed', Helpers::translate("Failed To Add Your Email To The Subscription List."), 'danger', 'bottom');
            }
            return back();
        } else {
            Notification::setNotification('Notice', Helpers::translate("You are already in Subscriber List."), 'warning', 'bottom');
            return back();
        }

    }

}
