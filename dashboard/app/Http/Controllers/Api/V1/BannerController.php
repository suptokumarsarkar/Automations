<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Model\Admin;
use App\Model\Category;
use App\Model\Chat;
use App\Model\movie;
use App\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class BannerController extends Controller
{
    public function get_banners()
    {
        $movies = movie::orderBy('id', 'desc')->get();
        $banner = [];
        foreach ($movies as $movie) {
            if ($movie->banner) {
                if (count($banner) < 8) {
                    $movie->banner = url("/storage/app/public/movie/" . $movie->banner);
                    $movie->status = $this->upcoming($movie->id);
                    $banner[] = $movie;
                } else {
                    break;
                }
            }
        }

        return json_encode(['status' => 200, 'banners' => $banner]);
    }

    public function login(Request $request)
    {

        if (Session::has('default_captcha_code')) {
            Session::forget('default_captcha_code');
        }
        //end recaptcha validation

        if (auth('admin')->attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Admin::where("email",$request->email)->first();
            $user->fcm_token = $request->fcm;
            $user->save();
            return json_encode(['success' => 200, 'email' => $request->email]);
        }
        return json_encode(['success' => 201, 'data' => 'Credentials does not match.']);
    }

    public function download($email, $id)
    {
        $movie = movie::find($id);
        $movie->total_download = $movie->total_download + 1;
        $movie->save();
        return json_encode(['status' => 200, 'downloads' => $movie->total_download]);
    }

    public function moviesAll()
    {
        $movies = movie::get();
        $movieReturn = [];
        foreach ($movies as $movie) {
            $mvk = [];
            $mvk['banner'] = url("/storage/app/public/movie/" . $movie->banner);
            $mvk['id'] = $movie->id;
            $mvk['title'] = $movie->title;
            $mvk['description'] = $movie->description;
            $mvk['total_download'] = $movie->total_download;
            $mvk['tags'] = $movie->tags;
            $movie->status = $this->upcoming($movie->id);
            $movieReturn[] = $mvk;
        }

        return json_encode(['status' => 200, 'banners' => $movieReturn]);
    }

    public function movie($id)
    {
        $movies = movie::find($id);
        $movies->banner = url("/storage/app/public/movie/" . $movies->banner);
        $movies->tags = explode(',', $movies->tags);
        $movies->mimeType = $this->get_content_mime_type(basename(parse_url($movies->download_link, PHP_URL_PATH)));
        $movies->fileName = basename(parse_url($movies->download_link, PHP_URL_PATH));
        $movies->status = $this->upcoming($movies->id);
        $movies->categories = $this->getCategories($id);
        return json_encode(['status' => 200, 'banners' => $movies]);
    }


    public
    function get_content_mime_type($content)
    {
        $mimes = array(
            'txt' => 'text/plain',
            'htm' => 'text/html',
            'html' => 'text/html',
            'php' => 'text/html',
            'css' => 'text/css',
            'js' => 'application/javascript',
            'json' => 'application/json',
            'xml' => 'application/xml',
            'swf' => 'application/x-shockwave-flash',
            'flv' => 'video/x-flv',
            // images
            'png' => 'image/png',
            'jpe' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'jpg' => 'image/jpeg',
            'gif' => 'image/gif',
            'bmp' => 'image/bmp',
            'ico' => 'image/vnd.microsoft.icon',
            'tiff' => 'image/tiff',
            'tif' => 'image/tiff',
            'svg' => 'image/svg+xml',
            'svgz' => 'image/svg+xml',
            // archives
            'zip' => 'application/zip',
            'rar' => 'application/x-rar-compressed',
            'exe' => 'application/x-msdownload',
            'msi' => 'application/x-msdownload',
            'cab' => 'application/vnd.ms-cab-compressed',
            // audio/video
            'mp3' => 'audio/mpeg',
            'qt' => 'video/quicktime',
            'mov' => 'video/quicktime',
            'mkv' => 'video/webm',
            'webm' => 'video/webm',
            'mp4' => 'video/mp4',
            // adobe
            'pdf' => 'application/pdf',
            'psd' => 'image/vnd.adobe.photoshop',
            'ai' => 'application/postscript',
            'eps' => 'application/postscript',
            'ps' => 'application/postscript',
            // ms office
            'doc' => 'application/msword',
            'rtf' => 'application/rtf',
            'xls' => 'application/vnd.ms-excel',
            'ppt' => 'application/vnd.ms-powerpoint',
            'docx' => 'application/msword',
            'xlsx' => 'application/vnd.ms-excel',
            'pptx' => 'application/vnd.ms-powerpoint',
            // open office
            'odt' => 'application/vnd.oasis.opendocument.text',
            'ods' => 'application/vnd.oasis.opendocument.spreadsheet',
        );

        $extension = explode(".", $content);
        $ext = $extension[count($extension) - 1];
        if (isset($mimes[$ext])) {
            return $mimes[$ext];
        } else {
            return 'video/webm';
        }

    }

    public function getCategories($id)
    {
        $movie = movie::find($id);
        $category = json_decode($movie->category);
        $names = [];
        foreach ($category as $id) {
            $names[] = Category::find($id)->name;
        }
        return $names;
    }


    public function topmovie()
    {
        $movies = movie::where('publish_date', '<=', date("Y-m-d"))->orderBy('popular', 'desc')->get();
        $banner = [];
        foreach ($movies as $movie) {
            if (count($banner) < 20) {
                $movie->banner = url("/storage/app/public/movie/" . $movie->banner);
                $movie->status = $this->upcoming($movie->id);
                $banner[] = $movie;
            } else {
                break;
            }
        }
        $banner = $this->multibanner($banner);
        return json_encode(['status' => 200, 'banners' => $banner]);
    }


    public function allpopular()
    {
        $movies = movie::where('publish_date', '<=', date("Y-m-d"))->orderBy('popular', 'desc')->get();
        $banner = [];
        foreach ($movies as $movie) {
            if (count($banner) < 50) {
                $movie->banner = url("/storage/app/public/movie/" . $movie->banner);
                $movie->status = $this->upcoming($movie->id);
                $banner[] = $movie;
            } else {
                break;
            }
        }
        return json_encode(['status' => 200, 'banners' => $banner]);
    }

    public function upcomingMovies()
    {
        $movies = movie::where('publish_date', '>', date("Y-m-d"))->orderBy('popular', 'desc')->get();
        $banner = [];
        foreach ($movies as $movie) {
            if (count($banner) < 50) {
                $movie->banner = url("/storage/app/public/movie/" . $movie->banner);
                $movie->status = $this->upcoming($movie->id);
                $banner[] = $movie;
            } else {
                break;
            }
        }
        return json_encode(['status' => 200, 'banners' => $banner]);
    }


    public function categories()
    {
        $movies = Category::get();
        $banner = [];
        foreach ($movies as $movie) {
            if (strtotime($movie->publish_date) < time()) {
                $movie->banner = url("/storage/app/public/category/" . $movie->image);
                $movie->total = $this->get_movies($movie->id);
                $banner[] = $movie;
            } else {
                break;
            }
        }
        $banner = $this->multibanner($banner);
        return json_encode(['status' => 200, 'banners' => $banner]);
    }

    public function allcategories()
    {
        $movies = Category::get();
        $banner = [];
        foreach ($movies as $movie) {
            if (strtotime($movie->publish_date) < time()) {
                $movie->banner = url("/storage/app/public/category/" . $movie->image);
                $movie->total = $this->get_movies($movie->id);
                $banner[] = $movie;
            } else {
                break;
            }
        }
        return json_encode(['status' => 200, 'banners' => $banner]);
    }

    public function categorymovie($category_id)
    {
        $movies = movie::orderBy('publish_date', 'desc')->get();
        $mv = [];
        foreach ($movies as $movie) {
            if (in_array($category_id, json_decode($movie->category))) {
                $movie->banner = url("/storage/app/public/movie/" . $movie->banner);
                $movie->status = $this->upcoming($movie->id);
                $mv[] = $movie;

            }
        }
        return json_encode(['status' => 200, 'category' => Category::find($category_id), 'banners' => $mv]);
    }


    public function upcoming($id)
    {
        $movie = movie::find($id);
        if (strtotime($movie->publish_date) > time()) {
            return "upcoming";
        } else {
            return "published";
        }
    }


    public function get_movies($category_id)
    {
        $movies = movie::get();
        $count = 0;
        foreach ($movies as $movie) {
            if (in_array($category_id, json_decode($movie->category))) {
                $count += 1;
            }
        }
        return $count;
    }

    public function latestMovies()
    {
        $movies = movie::orderBy('publish_date', 'desc')->orderBy('total_download')->get();
        $banner = [];
        foreach ($movies as $movie) {
            if (strtotime($movie->publish_date) < time()) {
                if (count($banner) < 20) {
                    $movie->banner = url("/storage/app/public/movie/" . $movie->banner);
                    $movie->status = $this->upcoming($movie->id);

                    $banner[] = $movie;
                } else {
                    break;
                }
            }
        }
        $banner = $this->multibanner($banner);
        return json_encode(['status' => 200, 'banners' => $banner]);
    }

    public function alllatestMovies()
    {
        $movies = movie::orderBy('publish_date', 'desc')->get();
        $banner = [];
        foreach ($movies as $movie) {
            if (strtotime($movie->publish_date) < time()) {
                if (count($banner) < 50) {
                    $movie->banner = url("/storage/app/public/movie/" . $movie->banner);
                    $movie->status = $this->upcoming($movie->id);

                    $banner[] = $movie;
                } else {
                    break;
                }
            }
        }
        return json_encode(['status' => 200, 'banners' => $banner]);
    }

    public function fng($data)
    {
        foreach ($data as $lim) {
            if (is_array($lim)) {
                $this->fng($lim);
            } else {
                echo $lim . " ";
            }
        }
    }

    function multibanner(array $banner)
    {
        $returner = [];
        $key = 0;
        foreach ($banner as $bn) {
            $returner[$key][] = $bn;
            if (count($returner[$key]) == 2) {
                $key += 1;
            }


        }
        return $returner;
    }

    public function AddMessage($email, Request $request)
    {
        $user = User::where("email", $email)->first();
        $message = $request->message;
        $to = "Admins";
        $chat = new Chat;
        $chat->chat_from = $user->id;
        $chat->chat_to = $to;
        $chat->movie_id = '';
        $chat->message = $message;
        $chat->chat_read = 0;
        $chat->attachment = '';
        if ($chat->save()) {
            $admins = Admin::get();
            $ids = [];
            foreach ($admins as $admin) {
                if ($admin->fcm_token) {
                    $ids[] = $admin->fcm_token;
                }
            }
            $title = "Message from " . $user->f_name;
            $descriptions = $message;
            $this->sendMessage($title, $descriptions, $ids, "/chat/" . $user->id);
        }
        return json_encode(["status" => 200, "id" => $chat->id, 'time' => date("h:i s, d M Y", strtotime($chat->created_at))]);

    }

    public function admin_message($id, Request $request)
    {
        $user = User::find($id);
        $message = $request->message;
        $chat = new Chat;
        $chat->chat_from = "Admins";
        $chat->chat_to = $id;
        $chat->movie_id = '';
        $chat->message = $message;
        $chat->chat_read = 0;
        $chat->attachment = '';
        if ($chat->save()) {
            $ids = [$user->cm_firebase_token];
            $title = "Message";
            $descriptions = $message;
            $this->sendMessage($title, $descriptions, $ids);
        }

        return json_encode(["status" => 200, "id" => $chat->id, 'time' => date("h:i s, d M Y", strtotime($chat->created_at))]);
    }

    public function messageList()
    {
        $chats = Chat::orderBy('id', 'desc')->get();
        $data = [];
        $dataAdded = [];
        foreach ($chats as $chat) {
            if ($chat->chat_from != "Admins" && !in_array($chat->chat_from, $dataAdded)) {
                $data[] = [
                    "user_id" => $chat->chat_from,
                    "user_name" => User::find($chat->chat_from) ? User::find($chat->chat_from)->f_name : "No Name",
                    "last_message" => $chat->message,
                    'last_message_time' => date("h:i s, d M Y", strtotime($chat->created_at)),
                    'unread' => $this->calculate_unread($chat->chat_from)
                ];
                $dataAdded[] = $chat->chat_from;
            }

        }

        return json_encode(["status" => 200, "data" => $data]);
    }

    public function calculate_unread($id){
        return Chat::where([['chat_from',$id],['chat_read','=',0]])->get()->count();
    }
    public function adminMarkAsRead($id){
        $chats = Chat::where("chat_from",$id)->get();
        foreach($chats as $chat)
        {
            $chat->chat_read = 1;
            $chat->save();
        }
    }

    public function adminMarkNonAdminAsRead($id){
        $chats = Chat::where("chat_to",$id)->get();
        foreach($chats as $chat)
        {
            $chat->chat_read = 1;
            $chat->save();
        }
    }

    public function AdminMessage($id, $time)
    {
        $id = User::where("email", $id)->first()->id;
        if ($time == "All") {
            $chat = Chat::where("chat_from", $id)->orWhere("chat_to", $id)->get();
        } else {
            $chats = Chat::where("chat_from", $id)->orWhere("chat_to", $id)->get();
            $chat = [];
            foreach ($chats as $ct) {
                if ($ct->id > $time) {
                    $chat[] = $ct;
                }
            }
        }
        foreach ($chat as $ch) {
            $ch->time = date("h:i s, d M Y", strtotime($ch->created_at));
        }
        $this->adminMarkNonAdminAsRead($id);
        return json_encode(["status" => 200, 'data' => $chat]);
    }

    public function AdminMessage2($id, $time)
    {
        $id = User::find($id)->id;
        if ($time == "All") {
            $chat = Chat::where("chat_from", $id)->orWhere("chat_to", $id)->get();
        } else {
            $chats = Chat::where("chat_from", $id)->orWhere("chat_to", $id)->get();
            $chat = [];
            foreach ($chats as $ct) {
                if ($ct->id > $time) {
                    $chat[] = $ct;
                }
            }
        }
        foreach ($chat as $ch) {
            $ch->time = date("h:i s, d M Y", strtotime($ch->created_at));
        }
        $this->adminMarkAsRead($id);
        return json_encode(["status" => 200, 'data' => $chat]);
    }


    public function sendMessage($title, $descriptions, $ids, $page = "/chat")
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
            'include_player_ids' => $ids,
            'data' => array(
                "page" => $page
            ),
            //'big_picture' => $icon,
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
