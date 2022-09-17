<?php

namespace App\Http\Controllers\Admin;

use App\CentralLogics\Extra;
use App\CentralLogics\Helpers;
use App\Http\Controllers\Controller;
use App\Model\Admin;
use App\Model\BusinessSetting;
use App\Model\AppsData;
use App\Plan;
use App\SeoMetaData;
use App\StoryCategory;
use App\StoryPost;
use App\Subscription;
use App\User;
use App\WebSetting;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DashboardController extends Controller
{
    public function fcm($id)
    {
        $fcm_token = Admin::find(auth('admin')->id())->fcm_token;
        $data = [
            'title' => 'New auto generate message arrived from admin dashboard',
            'description' => $id,
            'order_id' => '',
            'image' => '',
        ];
        Helpers::send_push_notif_to_device($fcm_token, $data);

        return "Notification sent to admin";
    }

    public function dashboard(Request $request)
    {

        return view('admin-views.dashboard');

    }

    public function generalSettings(Request $request)
    {

        return view('admin-views.generalSettings');

    }

    public function termsAndConditions(Request $request)
    {

        return view('admin-views.termsAndConditions');

    }

    public function termsAndConditionsPost(Request $request)
    {
        if ($request->data['termsAndConditions']) {
            if ($rk = WebSetting::WHERE("key", 'termsAndConditions')->first()) {
                $rk->value = $request->data['termsAndConditions'];
                $rk->save();
            } else {
                $rk = new WebSetting;
                $rk->key = "termsAndConditions";
                $rk->value = $request->data['termsAndConditions'];
                $rk->save();
            }
        }
        Toastr::success("Updated Successfully.");
        return back();

    }

    public function paymentSettings(Request $request)
    {

        return view('admin-views.paymentSettings');

    }

    public function paymentSettingsPost(Request $request)
    {
        if ($request->data['paypalClientId']) {
            if ($rk = WebSetting::WHERE("key", 'paypalClientId')->first()) {
                $rk->value = $request->data['paypalClientId'];
                $rk->save();
            } else {
                $rk = new WebSetting;
                $rk->key = "paypalClientId";
                $rk->value = $request->data['paypalClientId'];
                $rk->save();
            }
        }
        if ($request->data['stripePrivateKey']) {
            if ($rk = WebSetting::WHERE("key", 'stripePrivateKey')->first()) {
                $rk->value = $request->data['stripePrivateKey'];
                $rk->save();
            } else {
                $rk = new WebSetting;
                $rk->key = "stripePrivateKey";
                $rk->value = $request->data['stripePrivateKey'];
                $rk->save();
            }
        }
        if ($request->data['stripePublicKey']) {
            if ($rk = WebSetting::WHERE("key", 'stripePublicKey')->first()) {
                $rk->value = $request->data['stripePublicKey'];
                $rk->save();
            } else {
                $rk = new WebSetting;
                $rk->key = "stripePublicKey";
                $rk->value = $request->data['stripePublicKey'];
                $rk->save();
            }
        }
        Toastr::success("Updated Successfully.");
        return back();

    }

    public function privacyPolicy(Request $request)
    {

        return view('admin-views.privacyPolicy');

    }

    public function privacyPolicyPost(Request $request)
    {
        if ($request->data['privacyPolicy']) {
            if ($rk = WebSetting::WHERE("key", 'privacyPolicy')->first()) {
                $rk->value = $request->data['privacyPolicy'];
                $rk->save();
            } else {
                $rk = new WebSetting;
                $rk->key = "privacyPolicy";
                $rk->value = $request->data['privacyPolicy'];
                $rk->save();
            }
        }
        Toastr::success("Updated Successfully.");
        return back();

    }

    public function cookiePolicy(Request $request)
    {

        return view('admin-views.cookiePolicy');

    }

    public function cookiePolicyPost(Request $request)
    {
        if ($request->data['cookiePolicy']) {
            if ($rk = WebSetting::WHERE("key", 'cookiePolicy')->first()) {
                $rk->value = $request->data['cookiePolicy'];
                $rk->save();
            } else {
                $rk = new WebSetting;
                $rk->key = "cookiePolicy";
                $rk->value = $request->data['cookiePolicy'];
                $rk->save();
            }
        }
        Toastr::success("Updated Successfully.");
        return back();

    }
    public function loginSetup(Request $request)
    {

        return view('admin-views.loginSetup');

    }

    public function generalSettingsPost(Request $request)
    {
        if ($request->data['facebookUrl']) {
            if ($rk = WebSetting::WHERE("key", 'facebookUrl')->first()) {
                $rk->value = $request->data['facebookUrl'];
                $rk->save();
            } else {
                $rk = new WebSetting;
                $rk->key = "facebookUrl";
                $rk->value = $request->data['facebookUrl'];
                $rk->save();
            }
        }
        if ($request->data['linkedinUrl']) {
            if ($rk = WebSetting::WHERE("key", 'linkedinUrl')->first()) {
                $rk->value = $request->data['linkedinUrl'];
                $rk->save();
            } else {
                $rk = new WebSetting;
                $rk->key = "linkedInUrl";
                $rk->value = $request->data['linkedinUrl'];
                $rk->save();
            }
        }
        if ($request->data['googlePlusUrl']) {
            if ($rk = WebSetting::WHERE("key", 'googlePlusUrl')->first()) {
                $rk->value = $request->data['googlePlusUrl'];
                $rk->save();
            } else {
                $rk = new WebSetting;
                $rk->key = "googlePlusUrl";
                $rk->value = $request->data['googlePlusUrl'];
                $rk->save();
            }
        }
        if ($request->data['twitterUrl']) {
            if ($rk = WebSetting::WHERE("key", 'twitterUrl')->first()) {
                $rk->value = $request->data['twitterUrl'];
                $rk->save();
            } else {
                $rk = new WebSetting;
                $rk->key = "twitterUrl";
                $rk->value = $request->data['twitterUrl'];
                $rk->save();
            }
        }
        if ($request->data['youtubeUrl']) {
            if ($rk = WebSetting::WHERE("key", 'youtubeUrl')->first()) {
                $rk->value = $request->data['youtubeUrl'];
                $rk->save();
            } else {
                $rk = new WebSetting;
                $rk->key = "youtubeUrl";
                $rk->value = $request->data['youtubeUrl'];
                $rk->save();
            }
        }
        if ($request->data['copyrightText']) {
            if ($rk = WebSetting::WHERE("key", 'copyrightText')->first()) {
                $rk->value = $request->data['copyrightText'];
                $rk->save();
            } else {
                $rk = new WebSetting;
                $rk->key = "copyrightText";
                $rk->value = $request->data['copyrightText'];
                $rk->save();
            }
        }
        if ($request->key['pagination_limit']) {
            if ($rk = BusinessSetting::WHERE("key", 'pagination_limit')->first()) {
                $rk->value = $request->key['pagination_limit'];
                $rk->save();
            } else {
                $rk = new BusinessSetting;
                $rk->key = "pagination_limit";
                $rk->value = $request->key['pagination_limit'];
                $rk->save();
            }
        }
        if ($request->hasFile('image')) {
            $input_file = $request->file('image')->getClientOriginalName();
            $extension = pathinfo($input_file, PATHINFO_EXTENSION);
            $logo = Helpers::upload('logo/', $extension, $request->file('image'));

            if ($rk = BusinessSetting::WHERE("key", 'logo')->first()) {
                $rk->value = $logo;
                $rk->save();
            } else {
                $rk = new BusinessSetting;
                $rk->key = "logo";
                $rk->value = $logo;
                $rk->save();
            }
        }

        Toastr::success("Updated Successfully.");
        return back();

    }



    public function loginSetupPOST(Request $request)
    {

        if ($request->key['googleClientId']) {
            if ($rk = WebSetting::WHERE("key", 'googleClientId')->first()) {
                $rk->value = $request->key['googleClientId'];
                $rk->save();
            } else {
                $rk = new WebSetting;
                $rk->key = "googleClientId";
                $rk->value = $request->key['googleClientId'];
                $rk->save();
            }
        }

        if ($request->key['facebookAppId']) {
            if ($rk = WebSetting::WHERE("key", 'facebookAppId')->first()) {
                $rk->value = $request->key['facebookAppId'];
                $rk->save();
            } else {
                $rk = new WebSetting;
                $rk->key = "facebookAppId";
                $rk->value = $request->key['facebookAppId'];
                $rk->save();
            }
        }
        if ($request->key['microsoftClientId']) {
            if ($rk = WebSetting::WHERE("key", 'microsoftClientId')->first()) {
                $rk->value = $request->key['microsoftClientId'];
                $rk->save();
            } else {
                $rk = new WebSetting;
                $rk->key = "microsoftClientId";
                $rk->value = $request->key['microsoftClientId'];
                $rk->save();
            }
        }

        if ($request->active) {
            if ($rk = WebSetting::WHERE("key", '3rdPartyLogin')->first()) {
                $rk->value = json_encode($request->active, true);
                $rk->save();
            } else {
                $rk = new WebSetting;
                $rk->key = "3rdPartyLogin";
                $rk->value = json_encode($request->active, true);
                $rk->save();
            }
        } else {
            if ($rk = WebSetting::WHERE("key", '3rdPartyLogin')->first()) {
                $rk->value = json_encode([], true);
                $rk->save();
            } else {
                $rk = new WebSetting;
                $rk->key = "3rdPartyLogin";
                $rk->value = json_encode([], true);
                $rk->save();
            }
        }
        Toastr::success('Updated Successfully!');
        return back();

    }


    public function adminList(Request $request)
    {
        $query_param = [];
        $search = $request['search'];
        if ($request->has('search')) {
            $key = explode(' ', $request['search']);
            $customers = Admin::where(function ($q) use ($key) {
                foreach ($key as $value) {
                    $q->orWhere('f_name', 'like', "%{$value}%")
                        ->orWhere('l_name', 'like', "%{$value}%")
                        ->orWhere('email', 'like', "%{$value}%")
                        ->orWhere('phone', 'like', "%{$value}%");
                }
            });
            $query_param = ['search' => $request['search']];
        } else {
            $customers = new Admin;
        }

        $customers = $customers->latest()->paginate(Helpers::getPagination())->appends($query_param);
        return view('admin-views.admin.index', compact('customers', 'search'));
    }

    public function adminAdd()
    {
        return view("admin-views.admin.add");
    }

    public function adminEdit($id)
    {
        $admin = Admin::find($id);
        return view("admin-views.admin.edit", compact('admin'));
    }

    public function adminAddPost(Request $request)
    {
        $admin = new Admin;
        $admin->f_name = $request->f_name;
        $admin->l_name = $request->l_name;
        $admin->email = $request->email;
        $admin->phone = $request->phone;
        $admin->status = $request->status;
        $admin->password = Hash::make($request->password);
        if ($admin->save()) {
            Toastr::success('Added Successfully!');
        } else {
            Toastr::error('Failed To Add Admin');
        }

        return back();
    }

    public function adminEditPost(Request $request)
    {
        $admin = Admin::find($request->id);
        $admin->f_name = $request->f_name;
        $admin->l_name = $request->l_name;
        $admin->email = $request->email;
        $admin->phone = $request->phone;
        $admin->status = $request->status;
        if ($admin->save()) {
            Toastr::success('Updated Successfully!');
        } else {
            Toastr::error('Failed To Update Admin');
        }

        return back();
    }

    public function adminDeletePost(Request $request, $id)
    {
        $admin = Admin::find($id);
        $admin->delete();
        Toastr::success("Admin Deleted");

        return back();
    }

//    USER OPTION

    public function userList(Request $request)
    {
        $query_param = [];
        $search = $request['search'];
        if ($request->has('search')) {
            $key = explode(' ', $request['search']);
            $customers = User::where(function ($q) use ($key) {
                foreach ($key as $value) {
                    $q->orWhere('f_name', 'like', "%{$value}%")
                        ->orWhere('l_name', 'like', "%{$value}%")
                        ->orWhere('email', 'like', "%{$value}%")
                        ->orWhere('phone', 'like', "%{$value}%");
                }
            });
            $query_param = ['search' => $request['search']];
        } else {
            $customers = new User;
        }

        $customers = $customers->latest()->paginate(Helpers::getPagination())->appends($query_param);
        return view('admin-views.user.index', compact('customers', 'search'));
    }


    public function userAdd()
    {
        return view("admin-views.user.add");
    }

    public function userEdit($id)
    {
        $admin = User::find($id);
        return view("admin-views.user.edit", compact('admin'));
    }

    public function userAddPost(Request $request)
    {
        $admin = new User;
        $admin->name = $request->name;
        $admin->email = $request->email;
        $admin->password = Hash::make($request->password);
        if ($admin->save()) {
            Toastr::success('Added Successfully!');
        } else {
            Toastr::error('Failed To Add User');
        }

        return back();
    }

    public function userEditPost(Request $request)
    {
        $admin = User::find($request->id);
        $admin->name = $request->name;
        $admin->email = $request->email;

        if ($admin->save()) {
            Toastr::success('Updated Successfully!');
        } else {
            Toastr::error('Failed To Update User');
        }

        return back();
    }

    public function userDeletePost(Request $request, $id)
    {
        $admin = User::find($id);
        $admin->delete();
        Toastr::success("User Deleted");

        return back();
    }


//    Subscriber OPTION

    public function subscriberList(Request $request)
    {
        $query_param = [];
        $search = $request['search'];
        if ($request->has('search')) {
            $key = explode(' ', $request['search']);
            $customers = Subscription::where(function ($q) use ($key) {
                foreach ($key as $value) {
                    $q->orWhere('email', 'like', "%{$value}%");
                }
            });
            $query_param = ['search' => $request['search']];
        } else {
            $customers = new Subscription;
        }

        $customers = $customers->latest()->paginate(Helpers::getPagination())->appends($query_param);
        return view('admin-views.subscribers.index', compact('customers', 'search'));
    }


    public function subscriberAdd()
    {
        return view("admin-views.subscribers.add");
    }

    public function subscriberEdit($id)
    {
        $admin = Subscription::find($id);
        return view("admin-views.subscribers.edit", compact('admin'));
    }

    public function subscriberAddPost(Request $request)
    {
        $admin = new Subscription;
        $admin->email = $request->email;
        $admin->type = $request->type;
        if ($admin->save()) {
            Toastr::success('Added Successfully!');
        } else {
            Toastr::error('Failed To Add Subscriber');
        }

        return back();
    }

    public function subscriberEditPost(Request $request)
    {
        $admin = Subscription::find($request->id);
        $admin->type = $request->type;
        $admin->email = $request->email;

        if ($admin->save()) {
            Toastr::success('Updated Successfully!');
        } else {
            Toastr::error('Failed To Update Subscriber');
        }

        return back();
    }

    public function subscriberDeletePost(Request $request, $id)
    {
        $admin = Subscription::find($id);
        $admin->delete();
        Toastr::success("Subscriber Deleted");

        return back();
    }


//    SEO OPTION

    public function seoList(Request $request)
    {
        $query_param = [];
        $search = $request['search'];
        if ($request->has('search')) {
            $key = explode(' ', $request['search']);
            $customers = SeoMetaData::where(function ($q) use ($key) {
                foreach ($key as $value) {
                    $q->orWhere('slug', 'like', "%{$value}%")
                    ->orWhere('title', 'like', "%{$value}%");
                }
            });
            $query_param = ['search' => $request['search']];
        } else {
            $customers = new SeoMetaData;
        }

        $customers = $customers->latest()->paginate(Helpers::getPagination())->appends($query_param);
        return view('admin-views.seo.index', compact('customers', 'search'));
    }


    public function seoAdd()
    {
        return view("admin-views.seo.add");
    }

    public function seoEdit($id)
    {
        $admin = SeoMetaData::find($id);
        return view("admin-views.seo.edit", compact('admin'));
    }

    public function seoAddPost(Request $request)
    {
        $admin = new SeoMetaData;
        $admin->title = $request->title;
        $admin->slug = $request->slug ?: "";
        $admin->description = $request->description;
        $admin->keywords = $request->keywords;
        $admin->author = $request->author;
        $admin->type = $request->type;
        if ($admin->save()) {
            Toastr::success('Added Successfully!');
        } else {
            Toastr::error('Failed To Add Page');
        }

        return back();
    }

    public function seoEditPost(Request $request)
    {
        $admin = SeoMetaData::find($request->id);
        $admin->title = $request->title;
        $admin->slug = $request->slug;
        $admin->description = $request->description;
        $admin->keywords = $request->keywords;

        $admin->author = $request->author;
        $admin->type = $request->type;

        if ($admin->save()) {
            Toastr::success('Updated Successfully!');
        } else {
            Toastr::error('Failed To Update Page');
        }

        return back();
    }

    public function seoDeletePost(Request $request, $id)
    {
        $admin = SeoMetaData::find($id);
        $admin->delete();
        Toastr::success("Page Deleted");

        return back();
    }


//    Plan OPTION

    public function pricingList(Request $request)
    {
        $query_param = [];
        $search = $request['search'];
        if ($request->has('search')) {
            $key = explode(' ', $request['search']);
            $customers = Plan::where(function ($q) use ($key) {
                foreach ($key as $value) {
                    $q->orWhere('name', 'like', "%{$value}%")
                        ->orWhere('description', 'like', "%{$value}%");
                }
            });
            $query_param = ['search' => $request['search']];
        } else {
            $customers = new Plan;
        }

        $customers = $customers->latest()->paginate(Helpers::getPagination())->appends($query_param);
        return view('admin-views.plan.index', compact('customers', 'search'));
    }


    public function pricingAdd()
    {
        return view("admin-views.plan.add");
    }

    public function pricingEdit($id)
    {
        $admin = Plan::find($id);
        return view("admin-views.plan.edit", compact('admin'));
    }

    public function pricingAddPost(Request $request)
    {
        $admin = new Plan;
        $admin->name = $request->name;
        $admin->type = $request->type;
        $admin->description = $request->description;
        $admin->taskTime = $request->taskTime;
        $admin->maxConnections = $request->maxConnections;
        $admin->price = ($request->price == null ? 0 : $request->price);
        $admin->taskPerMonth = $request->taskPerMonth;
        if ($request->features) {
            foreach ($request->features as $feature) {
                $admin->$feature = 1;
            }
        }
        if ($admin->save()) {
            Toastr::success('Added Successfully!');
        } else {
            Toastr::error('Failed To Add Plan');
        }

        return back();
    }

    public function pricingEditPost(Request $request)
    {
        $admin = Plan::find($request->id);
        $admin->name = $request->name;
        $admin->type = $request->type;
        $admin->description = $request->description;
        $admin->taskTime = $request->taskTime;
        $admin->maxConnections = $request->maxConnections;
        $admin->price = ($request->price == null ? 0 : $request->price);
        $admin->taskPerMonth = $request->taskPerMonth;

        $admin->multiZaps = null;
        $admin->premiumApps = null;
        $admin->webHooks = null;
        $admin->logics = null;
        $admin->autoReply = null;
        $admin->premiumSupport = null;
        $admin->sharedAppConnection = null;
        $admin->sharedAccountConnection = null;
        $admin->folderPermission = null;
        $admin->formatters = null;
        $admin->filters = null;
        $admin->advancedAdminPermission = null;
        $admin->appsRestrictions = null;
        $admin->customDataRetention = null;
        $admin->userProvisioning = null;
        $admin->transferBeta = null;

        if ($request->features) {
            foreach ($request->features as $feature) {
                $admin->$feature = 1;
            }
        }
        if ($admin->save()) {
            Toastr::success('Updated Successfully!');
        } else {
            Toastr::error('Failed To Update Plan');
        }

        return back();
    }

    public function pricingDeletePost(Request $request, $id)
    {
        $admin = Plan::find($id);
        $admin->delete();
        Toastr::success("Plan Deleted");

        return back();
    }


    // Apps OPTIONS
    public function appsList(Request $request)
    {
        $query_param = [];
        $search = $request['search'];
        if ($request->has('search')) {
            $key = explode(' ', $request['search']);
            $customers = AppsData::where(function ($q) use ($key) {
                foreach ($key as $value) {
                    $q->orWhere('category', 'like', "%{$value}%");
                }
            });
            $query_param = ['search' => $request['search']];
        } else {
            $customers = new AppsData;
        }

        $customers = $customers->latest()->paginate(Helpers::getPagination())->appends($query_param);
        return view('admin-views.apps.index', compact('customers', 'search'));
    }

    public function appsAdd()
    {
        return view("admin-views.apps.add");
    }

    public function updateStatus(Request $request)
    {
        $id = $request->updateStatus;
        if($app = AppsData::find($id)){
            if($app->getStatus() == 0){
                $app->setStatus(1);
            }else{
                $app->setStatus(0);
            }
        }
        return 1;
    }

    public function appsDeletePost(Request $request, $id)
    {
        $admin = AppsData::find($id);
        $admin->delete();
        Toastr::success("App Data Deleted");

        return back();
    }
    public function appsEdit($id)
    {
        $app = AppsData::find($id);
        if(!$app){
            return back();
        }
        return view("admin-views.apps.edit", compact('app'));
    }


    public function appsAddPost(Request $request)
    {
        $appData = new AppsData;
        $info = [];
        if($request->get('AppInfo') !== null && is_array($request->get('AppInfo'))){
            foreach($request->AppInfo as $key => $name)
            {
                $value = $request->get("AppInfoValue")[$key];
                $info[$name] = $value;
            }
        }
        $info['status'] = $request->status;
        $appData->AppId = $request->AppId;
        $appData->AppName = $request->AppName;
        $appData->AppDescription = $request->AppDescription;
        $logo = '';
        if($request->hasFile('AppLogo'))
        {
            $input_file = $request->file('AppLogo')->getClientOriginalName();
            $extension = pathinfo($input_file, PATHINFO_EXTENSION);
            $logo = Helpers::upload('apps/', $extension, $request->file('AppLogo'));
        }
        $appData->AppLogo = $logo;
        $appData->AppInfo = json_encode($info, true);
        if($appData->save())
        {
            Toastr::success('Added Successfully!');
        } else {
            Toastr::error('Failed To Add App');
        }

        return back();
    }

    public function appsEditPost(Request $request)
    {
        $appData = AppsData::find($request->id);
        $info = [];
        if($request->get('AppInfo') !== null && is_array($request->get('AppInfo'))){
            foreach($request->AppInfo as $key => $name)
            {
                $value = $request->get("AppInfoValue")[$key];
                $info[$name] = $value;
            }
        }
        $info['status'] = $request->status;
        $appData->AppId = $request->AppId;
        $appData->AppName = $request->AppName;
        $appData->AppDescription = $request->AppDescription;
        if($request->hasFile('AppLogo'))
        {
            $input_file = $request->file('AppLogo')->getClientOriginalName();
            $extension = pathinfo($input_file, PATHINFO_EXTENSION);
            $logo = Helpers::upload('apps/', $extension, $request->file('AppLogo'));
            $appData->AppLogo = $logo;
        }
        $appData->AppInfo = json_encode($info, true);
        if($appData->save())
        {
            Toastr::success('Updated Successfully!');
        } else {
            Toastr::error('Failed To Update App');
        }

        return back();
    }

    // CATEGORY OPTIONS
    public function allCategory(Request $request)
    {
        $query_param = [];
        $search = $request['search'];
        if ($request->has('search')) {
            $key = explode(' ', $request['search']);
            $customers = StoryCategory::where(function ($q) use ($key) {
                foreach ($key as $value) {
                    $q->orWhere('category', 'like', "%{$value}%");
                }
            });
            $query_param = ['search' => $request['search']];
        } else {
            $customers = new StoryCategory;
        }

        $customers = $customers->latest()->paginate(Helpers::getPagination())->appends($query_param);
        return view('admin-views.storyCategory.index', compact('customers', 'search'));
    }


    public function addCategory()
    {
        $category = StoryCategory::get();
        return view("admin-views.storyCategory.add", compact('category'));
    }

    public function categoryEdit($id)
    {
        $admin = StoryCategory::find($id);
        $category = StoryCategory::get();

        return view("admin-views.storyCategory.edit", compact('admin', 'category'));
    }

    public function categoryAddPost(Request $request)
    {
        $admin = new StoryCategory;
        $admin->category = $request->category;
        $admin->parentId = $request->parentId;
        if ($admin->save()) {
            Toastr::success('Added Successfully!');
        } else {
            Toastr::error('Failed To Add Category');
        }

        return back();
    }

    public function categoryEditPost(Request $request)
    {
        $admin = StoryCategory::find($request->id);
        $admin->category = $request->category;
        $admin->parentId = $request->parentId;

        if ($admin->save()) {
            Toastr::success('Updated Successfully!');
        } else {
            Toastr::error('Failed To Update Category');
        }

        return back();
    }

    public function categoryDeletePost(Request $request, $id)
    {
        $admin = StoryCategory::find($id);
        $admin->delete();
        Toastr::success("Category Deleted");

        return back();
    }


    // POST OPTIONS

    public function allPosts(Request $request)
    {
        $query_param = [];
        $search = $request['search'];
        if ($request->has('search')) {
            $key = explode(' ', $request['search']);
            $customers = StoryPost::where(function ($q) use ($key) {
                foreach ($key as $value) {
                    $q->orWhere('title', 'like', "%{$value}%")
                        ->orWhere('tags', 'like', "%{$value}%");
                }
            });
            $query_param = ['search' => $request['search']];
        } else {
            $customers = new StoryPost;
        }

        $customers = $customers->latest()->paginate(Helpers::getPagination())->appends($query_param);
        return view('admin-views.posts.index', compact('customers', 'search'));
    }

    public function addPost()
    {
        $category = StoryCategory::get();

        return view("admin-views.posts.add", compact('category'));
    }

    public function postEdit($id)
    {
        $admin = StoryPost::find($id);
        $category = StoryCategory::get();

        return view("admin-views.posts.edit", compact('admin', 'category'));
    }

    public function postAddPost(Request $request)
    {

        $admin = new StoryPost;
        $admin->title = $request->title;
        $admin->sortDescription = $request->sortDescription;
        $admin->longDescription = $request->posts;
        $admin->tags = $request->tags;
        $admin->view = 0;
        $admin->likes = 0;
        $admin->slug = rand();
        $admin->categoryIds = json_encode($request->categoryIds);

        $input_file = $request->file('image')->getClientOriginalName();
        $extension = pathinfo($input_file, PATHINFO_EXTENSION);

        $admin->thumbnail = Helpers::upload('banner/', $extension, $request->file('image'));
        $admin->postAddedBy = auth()->guard('admin')->id();
        if ($admin->save()) {
            Toastr::success('Added Successfully!');
        } else {
            Toastr::error('Failed To Add User');
        }

        return back();
    }

    public function postEditPost(Request $request)
    {
        $admin = StoryPost::find($request->id);
        $admin->title = $request->title;
        $admin->sortDescription = $request->sortDescription;
        $admin->longDescription = $request->posts;
        $admin->tags = $request->tags;
        $admin->categoryIds = json_encode($request->categoryIds);


        if ($request->hasFile('image')) {
            $input_file = $request->file('image')->getClientOriginalName();
            $extension = pathinfo($input_file, PATHINFO_EXTENSION);
            $admin->thumbnail = Helpers::upload('banner/', $extension, $request->file('image'));
        }
        $admin->postAddedBy = auth()->guard('admin')->id();
        if ($admin->save()) {
            Toastr::success('Added Successfully!');
        } else {
            Toastr::error('Failed To Add User');
        }

        if ($admin->save()) {
            Toastr::success('Updated Successfully!');
        } else {
            Toastr::error('Failed To Update Post');
        }

        return back();
    }

    public function postDeletePost(Request $request, $id)
    {
        $admin = StoryPost::find($id);
        $admin->delete();
        Toastr::success("Post Deleted");

        return back();
    }

}
