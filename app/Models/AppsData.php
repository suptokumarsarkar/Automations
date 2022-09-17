<?php

namespace App\Models;

use App\Logic\Helpers;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppsData extends Model
{
    use HasFactory;

    public function getLogo()
    {
        $appData = json_decode($this->AppInfo, true);
        if(isset($appData['AppLogo']))
        {
            return $appData['AppLogo'];
        }
        if($this->AppLogo !== '' || $this->AppLogo !== null){
            return Helpers::dashboardRoot()."storage/app/public/apps/".$this->AppLogo;
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
}
