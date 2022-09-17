<?php

namespace App\Logic;

use Illuminate\Support\Facades\Session;

class Notification
{
    public static function get($area = 'bottom')
    {
        $notification = Session::get("notification");
        $text = '';
        if ($prevNote = json_decode($notification, true)) {
            foreach ($prevNote as $key => $value) {
                if ($value['area'] == $area && $area == 'top') {
                    $text .= '
<div class="alert alert-'. $value['type'] .' alert-dismissible fade show" role="alert" onload="removeAfter(10, this)">
    <strong>' . $value['title'] . '</strong> ' . $value['message'] . '
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
';
                    unset($prevNote[$key]);
                }
                if ($value['area'] == $area && $area == 'bottom') {
                    $text .= '
<div class="alert auto-closer bottom-alert alert-'. $value['type'] .' alert-dismissible fade show" role="alert" removeAfter="10">
    <strong>' . $value['title'] . '</strong> ' . $value['message'] . '
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
';
                    unset($prevNote[$key]);
                }
            }
        }
        Session::put('notification', json_encode($prevNote, true));
        if($area == 'bottom')
        {
            return '<div class="bottom-alerts">'.$text.'</div>';
        }
        return $text;
    }

    public static function setNotification($title, $message, $type, $area)
    {
        $notification = Session::get("notification");
        $prevNote = [];
        $currentNote = [
            "title" => $title,
            "message" => $message,
            "type" => $type,
            "area" => $area,
            "id" => time()
        ];
        if ($notification !== true) {
            $prevNote = json_decode($notification, true);
        }
        $prevNote[] = $currentNote;
        Session::put('notification', json_encode($prevNote, true));
        return true;
    }

    public static function clearNotifications(){
        Session::flash('notification');
    }

}
