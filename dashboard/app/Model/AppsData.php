<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppsData extends Model
{

    public function getLogo()
    {
        $appData = json_decode($this->AppInfo, true);
        if(isset($appData['AppLogo']))
        {
            return $appData['AppLogo'];
        }
        if($this->AppLogo !== '' || $this->AppLogo !== null){
            return asset("storage/app/public/apps/".$this->AppLogo);
        }
        return asset("public/img/img.png");
    }

    public function getStatus()
    {
        $appData = json_decode($this->AppInfo, true);
        if(isset($appData['status']))
        {
            return $appData['status'];
        }else{
            return 0;
        }
    }

    public function setStatus($status)
    {
        $appData = json_decode($this->AppInfo, true);
        $appData['status'] =  $status;
        $this->AppInfo = json_encode($appData, true);
        $this->save();
    }
}
