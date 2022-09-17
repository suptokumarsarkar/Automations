<?php

namespace App\Http\Controllers\Admin;

use App\CentralLogics\Helpers;
use App\Http\Controllers\Controller;
use App\Model\Category;
use App\Model\movie;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MovieController extends Controller
{
    public function listMovie(Request $request)
    {
        $query_param = [];
        $search = $request['search'];
        if ($request->has('search')) {
            $key = explode(' ', $request['search']);
            $addons = movie::where(function ($q) use ($key) {
                foreach ($key as $value) {
                    $q->orWhere('title', 'like', "%{$value}%");
                }
            });
            $query_param = ['search' => $request['search']];
        } else {
            $addons = new movie();
        }

        $addons = $addons->orderBy('created_at')->paginate(Helpers::getPagination())->appends($query_param);
        return view('admin-views.movie.list', compact('addons', 'search'));
    }

    public function addMovie(Request $request)
    {

        $categories = Category::get();
        return view('admin-views.movie.index', ["categories" => $categories]);
    }

    public function addMoviePost(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'publish_date' => 'required',
        ]);


        $addon = new movie();
        //image upload
        if (!empty($request->file('thumbnail'))) {
            $thumbnail = Helpers::upload('movie/', 'png', $request->file('thumbnail'));
        } else {
            $thumbnail = 'def.png';
        }
        //image upload
        if (!empty($request->file('banner'))) {
            $banner = Helpers::upload('movie/', 'png', $request->file('banner'));
        } else {
            $banner = 'def.png';
        }

        $addon->title = $request->title;
        $addon->description = $request->description;
        $addon->tags = $request->tags;
        $addon->publish_date = $request->publish_date;
        $addon->category = json_encode($request->category);
        $addon->download_link = $request->download_link;
        $addon->watch_link = $request->watch_link;
        $addon->popular = $request->popular;
        $addon->banner = $banner;
        $addon->sub_category = 0;
        $download = rand(1, 9) . rand(1, 9) . rand(1, 9) . rand(1, 9);
        $addon->start_download = $download;
        $addon->total_download = $download;
        $addon->sub_sub_category = 0;
        $addon->thumbnail = $thumbnail;
        $addon->added_by = Auth::guard('admin')->user()->f_name;
        $addon->save();

        $this->sendMessage($addon->title, $addon->description, url('/storage/app/public/movie/' . $addon->banner), '/movie/'.$addon->id);

        Toastr::success("Added Successfully");
        return back();
    }

    public function editMovie($id)
    {
        $movie = movie::withoutGlobalScopes()->with('translations')->find($id);
        $categories = Category::get();
        return view('admin-views.movie.edit', compact('movie', 'categories'));
    }

    public function editMoviePost(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'publish_date' => 'required',
        ]);


        $addon = movie::find($id);
        //image upload
        if (!empty($request->file('thumbnail'))) {
            $thumbnail = Helpers::upload('movie/', 'png', $request->file('thumbnail'));
            Helpers::delete('movie/' . $addon['thumbnail']);

            $addon->thumbnail = $thumbnail;
        } else {
            $thumbnail = 'def.png';
        }
        //image upload
        if (!empty($request->file('banner'))) {
            $banner = Helpers::upload('movie/', 'png', $request->file('banner'));
            Helpers::delete('movie/' . $addon['banner']);
            $addon->banner = $banner;
        } else {
            $banner = 'def.png';
        }

        $addon->title = $request->title;
        $addon->description = $request->description;
        $addon->tags = $request->tags;
        $addon->publish_date = $request->publish_date;
        $addon->category = json_encode($request->category);
        $addon->download_link = $request->download_link;
        $addon->watch_link = $request->watch_link;
        $addon->popular = $request->popular;
        $addon->added_by = Auth::guard('admin')->user()->f_name;
        $addon->save();
        $this->sendMessage($addon->title, $addon->description, url('/storage/app/public/movie/' . $addon->banner), '/movie/'.$addon->id);

        Toastr::success('Movie Updated successfully!');
        return back();
    }

    public function removeMovie($id, Request $request)
    {
        $banner = movie::find($id);
        Helpers::delete('movie/' . $banner['banner']);
        Helpers::delete('movie/' . $banner['thumbnail']);
        $banner->delete();
        Toastr::success('Movie removed!');
        return back();
    }

    public function sendMessage($title, $descriptions, $icon, $page = "grid-ex4")
    {
        $headings = array(
            "en" => $title
        );
        $content = array(
            "en" => $descriptions
        );
        $hashes_array = array();
        $fields = array(
            'app_id' => "50cdeb17-2eaa-466b-ab96-8d9ac5a15488",
            'included_segments' => array(
                'Subscribed Users'
            ),
            'data' => array(
                "page" => $page
            ),
            'big_picture' => $icon,
            'contents' => $content,
            'headings' => $headings,
        );

        $fields = json_encode($fields);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json; charset=utf-8',
            'Authorization: Basic MmY0NGU3N2QtN2JiMS00MzUxLTkyMDgtOWJkMDI2YWIyNjUx'
        ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

        $response = curl_exec($ch);
        curl_close($ch);

        return $response;
    }
}
