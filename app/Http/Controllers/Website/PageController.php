<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Logic\Helpers;
use App\Models\Plan;
use App\Models\StoryPost;
use App\Models\WebSetting;
use Illuminate\Support\Facades\Auth;

class PageController extends Controller
{
    public function logout(){
        Auth::logout();
        return redirect()->route('login');
    }
    public function homePage()
    {
        return view("Website.home");
    }

    public function pricingPage()
    {
        $plans = Plan::orderBy("price")->get();
        return view("Website.pricing", compact('plans'));
    }

    public function teamAndCompaniesPage()
    {
        return view("Website.teamAndCompanies");
    }

    public function ProductHowItWorks(){
        return view("Website.Products.HowItWorks");
    }
    public function ProductFeatures(){
        return view("Website.Products.Features");
    }
    public function ProductSecurity(){
        return view("Website.Products.Security");
    }
    public function ProductCustomerStories(){
        $posts = StoryPost::where("tags", 'like', '%customer%')->get();
        return view("Website.Products.CustomerStories", compact('posts'));
    }
    public function ExploreRoles(){
        return view("Website.Explore.Roles");
    }
    public function ExploreApps(){
        return view("Website.Explore.Apps");
    }
    public function ExplorePopular(){
        return view("Website.Explore.Popular");
    }

    public function ViewPost($id, $title){
        $post = StoryPost::find($id);
        if(!$post){
            return redirect()->route('home');
        }

        return view("Website.Products.ViewPosts", compact('post'));
    }

    public function CookiePolicy(){
        $cookiePolicy = WebSetting::WHERE("key", 'cookiePolicy')->first() ? WebSetting::WHERE("key", 'cookiePolicy')->first()->value : "";
        $post = new StoryPost;
        $post->title = "Cookie Policy";
        $post->longDescription = $cookiePolicy;

        return view("Website.Products.Policy", compact('post'));
    }
    public function PrivacyPolicy(){
        $cookiePolicy = WebSetting::WHERE("key", 'privacyPolicy')->first() ? WebSetting::WHERE("key", 'privacyPolicy')->first()->value : "";
        $post = new StoryPost;
        $post->title = "Privacy Policy";
        $post->longDescription = $cookiePolicy;

        return view("Website.Products.Policy", compact('post'));
    }
    public function TermsAndConditions(){
        $cookiePolicy = WebSetting::WHERE("key", 'termsAndConditions')->first() ? WebSetting::WHERE("key", 'termsAndConditions')->first()->value : "";
        $post = new StoryPost;
        $post->title = "Terms And Conditions";
        $post->longDescription = $cookiePolicy;

        return view("Website.Products.Policy", compact('post'));
    }

    public function gmailCheckup()
    {
        return view("Website.GmailCheckup");
    }
}
