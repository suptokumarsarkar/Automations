<?php

namespace App\Logic;

use App\Models\SeoMetaData;
use App\Models\StoryCategory;
use App\Models\WebSetting;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Storage;

class Helpers
{
    public static function production($type)
    {
        if ($type == 'version') {
            return "?v=" . rand();
//            return "?v=r1";
        }
        return "";
    }

    public static function dashboardRoot(): string
    {
        return url('dashboard') . "/";
    }


    public static function getSeoData()
    {
        $request = Request::url();
        $slug = str_replace(url('/'), '', $request);

        $data = SeoMetaData::where("slug", $slug)->first();
        if ($data) {
            return $data;
        }
        return false;
    }

    public static function hasSeoData()
    {
        $request = Request::url();
        $slug = str_replace(url('/'), '', $request);

        $data = SeoMetaData::where("slug", $slug)->first();
        if ($data) {
            return true;
        }
        return false;
    }

    public static function getParentCategory($categoryId)
    {
        $category = StoryCategory::find($categoryId);
        if ($category) {
            if ($category->parentId != 0) {
                return StoryCategory::find($category->parentId);
            } else {
                $parent = new StoryCategory;
                $parent->category = "ROOT";
                return $parent;
            }
        } else {
            $parent = new StoryCategory;
            $parent->category = "ROOT";
            return $parent;
        }
    }

    public static function getSubCategory($categoryId)
    {
        $category = StoryCategory::find($categoryId);
        if ($category) {
            if ($sub = StoryCategory::where("parentId", $categoryId)->get()) {
                return $sub;
            } else {
                return null;
            }
        } else {
            return null;
        }
    }


    public static function isActive3rdPartyLogin($loginkey)
    {
        $keys = WebSetting::WHERE("key", '3rdPartyLogin')->first() ? WebSetting::WHERE("key", '3rdPartyLogin')->first()->value : "[]";
        $key = json_decode($keys, 1);
        if (isset($key[$loginkey]) && $key[$loginkey] == "on") {
            return 1;
        }
        return 0;
    }

    public static function uploadFile(string $dir, string $format, $file = null, $type = 'image')
    {
        if ($file != null) {
            $fileName = \Carbon\Carbon::now()->toDateString() . "-" . uniqid() . "." . $format;
            if ($type != 'image') {
                $fileName = $type . "." . $format;
            }
            if (!Storage::disk('public')->exists($dir)) {
                Storage::disk('public')->makeDirectory($dir);
            }
            Storage::disk('public')->put($dir . $fileName, file_get_contents($file));
        } else {
            $fileName = 'def.png';
        }

        return $fileName;
    }

    public static function createFile(string $dir, string $format, $file = null, $type = 'image')
    {
        if ($file != null) {
            $fileName = \Carbon\Carbon::now()->toDateString() . "-" . uniqid() . "." . $format;
            if ($type != 'image') {
                $fileName = $type . "." . $format;
            }
            if (!Storage::disk('public')->exists($dir)) {
                Storage::disk('public')->makeDirectory($dir);
            }
            Storage::disk('public')->put($dir . $fileName, $file);
        } else {
            $fileName = $type . "." . $format;
        }

        return $fileName;
    }


    public static function updateFile(string $dir, $old_image, string $format, $image = null, $type = 'image')
    {
        if (Storage::disk('public')->exists($dir . $old_image)) {
            Storage::disk('public')->delete($dir . $old_image);
        }
        return Helpers::uploadFile($dir, $format, $image, $type);
    }

    public static function FileExists(string $dir, $file)
    {
        if (Storage::disk('public')->exists($dir . $file)) {
            return true;
        }
        return false;
    }

    public static function FileGetContents(string $dir, $file, $array = false)
    {
        if (Storage::disk('public')->exists($dir . $file)) {
            if ($array) {
                return json_decode(Storage::disk('public')->get($dir . $file), 1);
            }
            return Storage::disk('public')->get($dir . $file);
        }
        return null;
    }

    public static function deleteFile($full_path)
    {
        if (Storage::disk('public')->exists($full_path)) {
            Storage::disk('public')->delete($full_path);
        }
        return [
            'success' => 1,
            'message' => 'Removed successfully !'
        ];
    }


    public static function setEnvironmentValue($envKey, $envValue)
    {
        $envFile = app()->environmentFilePath();
        $str = file_get_contents($envFile);
        if (is_bool(env($envKey))) {
            $oldValue = var_export(env($envKey), true);
        } else {
            $oldValue = env($envKey);
        }
        if (strpos($str, $envKey) !== false) {
            $str = str_replace("{$envKey}={$oldValue}", "{$envKey}={$envValue}", $str);
        } else {
            $str .= "{$envKey}={$envValue}\n";
        }
        $fp = fopen($envFile, 'w');
        fwrite($fp, $str);
        fclose($fp);
        return $envValue;
    }

    public static function requestSender($url)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
        ));
        $response = curl_exec($curl);
        $data = json_decode($response, true);
        return $data;
    }

    public static function getPagination()
    {
        $pagination_limit = BusinessSetting::where('key', 'pagination_limit')->first();
        return $pagination_limit->value;
    }

    public static function remove_invalid_charcaters($str)
    {
        return str_ireplace(['\'', '"', ',', ';', '<', '>', '?'], ' ', $str);
    }

    public static function translate($key)
    {
        $local = session()->has('local') ? session('local') : 'en';
        App::setLocale($local);
        if (!file_exists(base_path('resources/lang/' . $local . '/messages.php'))) {
            $lang_array = [
                'language_code' => $local
            ];
            file_put_contents(base_path('resources/lang/' . $local . '/messages.php'), $str = "<?php return " . var_export($lang_array, true) . ";");
        }
        $lang_array = include(base_path('resources/lang/' . $local . '/messages.php'));
        $processed_key = ucfirst(str_replace('_', ' ', Helpers::remove_invalid_charcaters($key)));
        if (!array_key_exists($key, $lang_array)) {
            $lang_array[$key] = $processed_key;
            $str = "<?php return " . var_export($lang_array, true) . ";";
            file_put_contents(base_path('resources/lang/' . $local . '/messages.php'), $str);
            $result = $processed_key;
        } else {
            $result = __('messages.' . $key);
        }
        return $result;
    }

    public static function rap_with_form($input, $data = [], $formName = 'action_suffer', $vk = []): string
    {
        $html = "<form id='$formName' name='$formName' method='post' enctype='multipart/form-data'>";
        foreach ($input as $target) {
            $html .= $target;
        }
        $html .= "<input type='hidden' name='_token' value='" . csrf_token() . "'>";
        $html .= "<input type='hidden' name='data' value='" . json_encode($data, true) . "'>";
        foreach ($vk as $key => $value) {
            $html .= "<input type='hidden' name='$key' value='" . json_encode($value, true) . "'>";
        }
        $html .= "</form>";

        return $html;

    }

    public static function freshEmail($str)
    {
        if (strpos($str, "<") !== false) {
            $start = strpos($str, '<');
            $end = strpos($str, '>', $start + 1);
            $length = $end - $start;
            return substr($str, $start + 1, $length - 1);
        } else {
            return $str;
        }
    }

    public static function IllitarableArray($data)
    {
        $array = [];
        foreach ($data as $value) {
            $name = str_replace('[]', '', $value['name']);
            if (isset($array[$name])) {
                if (is_array($array[$name])) {
                    $array[$name][] = $value['value'];
                } else {
                    $current = $array[$name];
                    $array[$name] = [$current];
                    $array[$name][] = $value['value'];
                }
            } else {
                $array[$name][] = $value['value'];
            }
        }
        return $array;
    }

    public static function evaluteData(array $data)
    {

        $ids = $data['id'];
        $dataString = $data;
        $value = [];
        foreach ($ids as $id) {
            $labelData = $data["label" . $id] ?? null;
            if (isset($labelData) && is_array($labelData)) {
                foreach ($labelData as $labelDatum) {
                    if (strpos($labelDatum, "[api]") !== false) {
                        $customString = str_replace('[api]', '', $labelDatum);
                        list($labelId, $stringItem) = explode("/24110/", $customString);
                        $value['api'][$labelId][] = $stringItem;
                    }
                    if (strpos($labelDatum, "[custom]") !== false) {
                        $value['string'][] = str_replace('[custom]', '', $labelDatum);
                    }
                    if (strpos($labelDatum, "[string]") !== false) {
                        $customString = str_replace('[string]', '', $labelDatum);
                        list($labelId, $stringItem) = explode("/24110/", $customString);

                        $value['string'][$labelId][] = $stringItem;

                    }
                }
            } elseif (is_string($labelData) && !empty($labelData)) {
                if (strpos($labelData, "[api]") !== false) {
                    $value['api'][] = str_replace('[api]', '', $labelData);
                }
                if (strpos($labelData, "[custom]") !== false) {
                    $value['string'][] = str_replace('[custom]', '', $labelData);
                }
                if (strpos($labelData, "[string]") !== false) {
                    $customString = str_replace('[string]', '', $labelData);
                    list($labelId, $stringItem) = explode("/24110/", $customString);

                    $value['string'][$labelId][] = $stringItem;

                }
            }

            foreach ($dataString as $key => $stringItem) {
                if (strpos($key, "string" . $id) !== false) {
                    $labelId = str_replace("string" . $id, '', $key);
                    if (is_array($stringItem)) {
                        foreach ($stringItem as $item) {
                            $value['string'][$labelId][] = $item;
                        }
                    } else {
                        $value['string'][$labelId] = $stringItem;
                    }
                }
            }
        }

        return $value;
    }

    public static function stringValueFillup(&$mainData, &$value)
    {
        if (isset($value['string'])) {
            foreach ($value['string'] as $key => $item) {
                if (is_array($item)) {
                    foreach ($item as $i) {
                        if (!isset($mainData[$key])) {
                            $mainData[$key] = [];
                        }
                        if (is_array($mainData[$key])) {
                            $mainData[$key][] = $i;
                        } else {
                            $st = $mainData[$key];
                            $mainData[$key] = [$st, $i];
                        }

                    }
                } else {
                    if (!isset($mainData[$key])) {
                        $mainData[$key] = [];
                    }
                    if (is_array($mainData[$key])) {
                        $mainData[$key][] = $item;
                    } else {
                        $st = $mainData[$key];
                        $mainData[$key] = [$st, $item];
                    }
                }
            }
        }
    }

    public static function arrayMarge($dataV, &$data)
    {
        foreach ($dataV as $d) {
            $data[] = $d;
        }
    }

    public static function mimeType($filename)
    {
        $idx = explode('.', $filename);
        $count_explode = count($idx);
        $idx = strtolower($idx[$count_explode - 1]);

        $mimet = array(
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

        if (isset($mimet[$idx])) {
            return $mimet[$idx];
        } else {
            return 'application/octet-stream';
        }
    }

    public static function wrap(array $views, $Fid)
    {
        $view = '';
        foreach ($views as $v) {
            $view .= $v;
        }
        return "<div class='accpeter_dt_$Fid'>$view</div>";
    }

    public static function margeIfArray(&$param)
    {
        foreach ($param as $key => $p) {
            if (is_array($p)) {
                if (count($p) == count($p, COUNT_RECURSIVE)) {
                    $param[$key] = implode(".", $p);
                } else {
                    $param[$key] = json_encode($p);
                }
            }
        }
    }

    public static function hideKeys($params)
    {
        $param = [];
        foreach ($params as $p) {
            $param[] = $p;
        }
        return $param;
    }

    public static function keyAndValue($headers, $is, $ij = false)
    {

        $hs = [];
        $i = 0;
        foreach ($headers as $header) {
            $hs[$header] = $is[$i] ?? "";
            $i++;
        }
        if ($ij) {
            foreach($is as $key => $value)
            {
                if(!array_key_exists($key, $hs) && !is_numeric($key)){
                    $hs[$key] = $value;
                }
            }
        }
        return $hs;
    }


}


function translate($key)
{
    $local = session()->has('local') ? session('local') : 'en';
    App::setLocale($local);
    if (!file_exists(base_path('resources/lang/' . $local . '/messages.php'))) {
        $lang_array = [
            'language_code' => $local
        ];
        file_put_contents(base_path('resources/lang/' . $local . '/messages.php'), $str = "<?php return " . var_export($lang_array, true) . ";");
    }
    $lang_array = include(base_path('resources/lang/' . $local . '/messages.php'));
    $processed_key = ucfirst(str_replace('_', ' ', Helpers::remove_invalid_charcaters($key)));
    if (!array_key_exists($key, $lang_array)) {
        $lang_array[$key] = $processed_key;
        $str = "<?php return " . var_export($lang_array, true) . ";";
        file_put_contents(base_path('resources/lang/' . $local . '/messages.php'), $str);
        $result = $processed_key;
    } else {
        $result = __('messages.' . $key);
    }
    return $result;
}

