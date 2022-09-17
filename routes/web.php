<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\QuoteController;
use App\Http\Controllers\Soft\PlanController;
use App\Http\Controllers\Soft\SubscribeController;
use App\Http\Controllers\Website\PageController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'loginAction'])->name('loginAction');
Route::get('/logout', [PageController::class, 'logout'])->name('logout');
Route::get('/signup', [AuthController::class, 'signup'])->name('register');
Route::post('/signup', [AuthController::class, 'signupAction'])->name('signupAction');
Route::post('/fastLogin', [AuthController::class, 'fastLogin'])->name('fastLogin');

Route::group(['middleware' => 'websiteAccess'], function () {

    Route::get('/', [PageController::class, 'homePage'])->name('home');
    Route::get('/pricing', [PageController::class, 'pricingPage'])->name('pricing');
    Route::get('/team-and-companies', [PageController::class, 'teamAndCompaniesPage'])->name('team-and-companies');

    Route::group(['prefix' => 'products', 'as' => 'products.'], function () {
        Route::get('/', [QuoteController::class, 'index'])->name('index');
        Route::get('how-it-works', [PageController::class, 'ProductHowItWorks'])->name('howItWorks');
        Route::get('features', [PageController::class, 'ProductFeatures'])->name('features');
        Route::get('customer-stories', [PageController::class, 'ProductCustomerStories'])->name('customerStories');
        Route::get('security', [PageController::class, 'ProductSecurity'])->name('security');
    });
    Route::group(['prefix' => 'explore', 'as' => 'explore.'], function () {
        Route::get('/', [QuoteController::class, 'index'])->name('index');
        Route::get('roles', [PageController::class, 'ExploreRoles'])->name('roles');
        Route::get('apps', [PageController::class, 'ExploreApps'])->name('apps');
        Route::get('popular-way-to-use', [PageController::class, 'ExplorePopular'])->name('popular');
    });
    Route::group(['prefix' => 'posts', 'as' => 'posts.'], function () {
        Route::get('/{id}/{title}', [PageController::class, 'ViewPost'])->name('index');
    });

    Route::group(['prefix' => 'policy', 'as' => 'policy.'], function () {
        Route::get('/cookie', [PageController::class, 'CookiePolicy'])->name('cookie');
        Route::get('/privacy', [PageController::class, 'PrivacyPolicy'])->name('privacy');
        Route::get('/terms-and-conditions', [PageController::class, 'TermsAndConditions'])->name('termsAndConditions');
    });

    Route::group(['prefix' => 'plans', 'as' => 'plans.', 'middleware' => 'softAccess'], function () {
        Route::get('/{id}/{title}', [PlanController::class, 'plan'])->name('index');
    });

    Route::group(['prefix' => 'subscribe', 'as' => 'subscribe.'], function () {
        Route::post('/', [SubscribeController::class, 'save'])->name('save');
    });
});

Route::get("/gmail-checkup", [PageController::class, 'gmailCheckup']);
include 'app.php';
