<?php

namespace App\Logic;

use App\Models\BusinessSetting;
use App\Models\WebSetting;

class Settings
{
    function __construct()
    {
        $settings = WebSetting::all();
        foreach ($settings as $setting)
        {
            $key = $setting->key;
            $this->$key = $setting->value;
        }
    }
    public function get($key)
    {
        if(isset($this->$key)){
            return $this->$key;
        }
        return '';
    }

    public static function fastGet($key)
    {
        $settings = WebSetting::all();
        foreach ($settings as $setting)
        {
            $keys = $setting->key;
            if($keys == $key){
                return $setting->value;
            }
        }
        return '';
    }

    public static function getLogo()
    {
        if($logo = BusinessSetting::WHERE("key", 'logo')->first()){
            return Helpers::dashboardRoot().'storage/app/public/logo/'. $logo->value;
        }
        return asset('/public/img/logo.png');
    }
    public static function getSiteName()
    {
        return Helpers::translate('LightNit');
    }

}
