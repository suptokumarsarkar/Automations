<?php

namespace App\Apps\Actions;

class ActionField
{
    public $name, $type, $multiple, $custom, $return, $data;
    public function getArray()
    {
        return json_decode(json_encode($this, true), true);
    }
}
