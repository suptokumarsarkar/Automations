<?php

namespace App\CentralLogics;

use App\StoryCategory;
use App\WebSetting;

class Extra
{
    public static function isActive3rdPartyLogin($loginkey)
    {
        $keys = WebSetting::WHERE("key",'3rdPartyLogin')->first() ? WebSetting::WHERE("key",'3rdPartyLogin')->first()->value : "[]";
        $key = json_decode($keys, 1);
        if(isset($key[$loginkey]) && $key[$loginkey] == "on"){
            return 1;
        }
        return 0;
    }

    public static function getParentCategory($categoryId)
    {
        $category = StoryCategory::find($categoryId);
        if($category){
            if ($category->parentId != 0){
               return StoryCategory::find($category->parentId);
            }else{
                $parent = new StoryCategory;
                $parent->category = "ROOT";
                return $parent;
            }
        }else{
            $parent = new StoryCategory;
            $parent->category = "ROOT";
            return $parent;
        }
    }

    public static function idToCategory($categoryIds)
    {
        $id = json_decode($categoryIds);
        $categoryNames = '';
        foreach($id as $catId)
        {
            if($category = StoryCategory::find($catId))
            {
                $categoryNames .= $category->category. ", ";
            }
        }

        return substr($categoryNames, 0,-2);
    }

    public static function getSubCategory($categoryId)
    {
        $category = StoryCategory::find($categoryId);
        if($category){
            if($sub = StoryCategory::where("parentId", $categoryId)->get()){
                return $sub;
            }else{
                return null;
            }
        }else{
            return null;
        }
    }

}
