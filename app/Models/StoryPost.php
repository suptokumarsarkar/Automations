<?php

namespace App\Models;

use App\Logic\Helpers;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoryPost extends Model
{
    use HasFactory;

    public function author()
    {
        $author = $this->postAddedBy;
        return Admin::find($author);
    }

    public function getThumbnail()
    {
        $rootPath = Helpers::dashboardRoot();
        return $rootPath . "storage/app/public/banner/" . $this->thumbnail;
    }
    public function getURI()
    {
        return url('/posts/'.$this->id.'/'.str_replace("+","-",urlencode($this->title)));
    }

    public function postTime()
    {
        $postLastTime = strtotime($this->updated_at);
        $pastAgo = time() - $postLastTime;
        if ($pastAgo < 0) {
            return "Recently Posted";
        }
        if ($pastAgo < 60) {
            return "A Few Seconds Ago";
        }
        if ($pastAgo < 3600) {
            return round($pastAgo / 60) . " Minutes Ago";
        }
        if ($pastAgo < 3600 * 24) {
            return round($pastAgo / 3600) . " Hours Ago";
        }
        if ($pastAgo < 3600 * 24 * 30) {
            return round($pastAgo / (3600 * 24)) . " Days Ago";
        }
        if ($pastAgo < 3600 * 24 * 30 * 12) {
            return round($pastAgo / (3600 * 24 * 30)) . " Months Ago";
        }
        if ($pastAgo > 3600 * 24 * 30 * 12) {
            return round($pastAgo / (3600 * 24 * 30 * 12)) . " Years Ago";
        }
    }
}
