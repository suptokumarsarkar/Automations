
<?php

use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'Admin', 'as' => 'admin.'], function () {
    /*authentication*/
    Route::group(['namespace' => 'Auth', 'prefix' => 'auth', 'as' => 'auth.'], function () {
        Route::get('/code/captcha/{tmp}', 'LoginController@captcha')->name('default-captcha');
        Route::get('login', 'LoginController@login')->name('login');
        Route::post('login', 'LoginController@submit')->middleware('actch');
        Route::get('logout', 'LoginController@logout')->name('logout');
    });
    /*authentication*/

    Route::group(['middleware' => ['admin']], function () {
        Route::get('/', 'DashboardController@dashboard')->name('dashboard');
        Route::get('settings', 'SystemController@settings')->name('settings');
        Route::post('settings', 'SystemController@settings_update');
        Route::post('settings-password', 'SystemController@settings_password_update')->name('settings-password');
        Route::get('/login-setup', 'DashboardController@loginSetup')->name('loginSetup');
        Route::post('/login-setup', 'DashboardController@loginSetupPost')->name('loginSetupPost');

        Route::get('/general-settings', 'DashboardController@generalSettings')->name('generalSettings');
        Route::post('/general-settings', 'DashboardController@generalSettingsPost')->name('generalSettingsPost');

        Route::get('/payment-settings', 'DashboardController@paymentSettings')->name('paymentSettings');
        Route::post('/payment-settings', 'DashboardController@paymentSettingsPost')->name('paymentSettingsPost');

        Route::post('/category/add', 'DashboardController@settings')->name('category.add');

        Route::group(['prefix' => 'admin'], function () {
            Route::get("/list", 'DashboardController@adminList')->name('adminList');
            Route::get("/add", 'DashboardController@adminAdd')->name('adminAdd');
            Route::post("/add", 'DashboardController@adminAddPost')->name('adminAddPost');
            Route::get("/edit/{id}", 'DashboardController@adminEdit')->name('adminEdit');
            Route::post("/update", 'DashboardController@adminEditPost')->name('adminEditPost');
            Route::delete("/delete/{id}", 'DashboardController@adminDeletePost')->name('adminDeletePost');
        });

        Route::group(['prefix' => 'apps'], function () {
            Route::get("/list", 'DashboardController@appsList')->name('appsList');
            Route::get("/add", 'DashboardController@appsAdd')->name('appsAdd');
            Route::post("/updateStatus", 'DashboardController@updateStatus')->name('updateStatus');
            Route::post("/add", 'DashboardController@appsAddPost')->name('appsAddPost');
            Route::get("/edit/{id}", 'DashboardController@appsEdit')->name('appsEdit');
            Route::post("/update", 'DashboardController@appsEditPost')->name('appsEditPost');
            Route::delete("/delete/{id}", 'DashboardController@appsDeletePost')->name('appsDeletePost');
        });

        Route::group(['prefix' => 'users'], function () {
            Route::get("/list", 'DashboardController@userList')->name('userList');
            Route::get("/add", 'DashboardController@userAdd')->name('userAdd');
            Route::post("/add", 'DashboardController@userAddPost')->name('userAddPost');
            Route::get("/edit/{id}", 'DashboardController@userEdit')->name('userEdit');
            Route::post("/update", 'DashboardController@userEditPost')->name('userEditPost');
            Route::delete("/delete/{id}", 'DashboardController@userDeletePost')->name('userDeletePost');
        });
        Route::group(['prefix' => 'subscribers'], function () {
            Route::get("/list", 'DashboardController@subscriberList')->name('subscriberList');
            Route::get("/add", 'DashboardController@subscriberAdd')->name('subscriberAdd');
            Route::post("/add", 'DashboardController@subscriberAddPost')->name('subscriberAddPost');
            Route::get("/edit/{id}", 'DashboardController@subscriberEdit')->name('subscriberEdit');
            Route::post("/update", 'DashboardController@subscriberEditPost')->name('subscriberEditPost');
            Route::delete("/delete/{id}", 'DashboardController@subscriberDeletePost')->name('subscriberDeletePost');
        });

        Route::group(['prefix' => 'seo'], function () {
            Route::get("/list", 'DashboardController@seoList')->name('seoList');
            Route::get("/add", 'DashboardController@seoAdd')->name('seoAdd');
            Route::post("/add", 'DashboardController@seoAddPost')->name('seoAddPost');
            Route::get("/edit/{id}", 'DashboardController@seoEdit')->name('seoEdit');
            Route::post("/update", 'DashboardController@seoEditPost')->name('seoEditPost');
            Route::delete("/delete/{id}", 'DashboardController@seoDeletePost')->name('seoDeletePost');
        });

        Route::group(['prefix' => 'pricing'], function () {
            Route::get("/list", 'DashboardController@pricingList')->name('pricingList');
            Route::get("/add", 'DashboardController@pricingAdd')->name('pricingAdd');
            Route::post("/add", 'DashboardController@pricingAddPost')->name('pricingAddPost');
            Route::get("/edit/{id}", 'DashboardController@pricingEdit')->name('pricingEdit');
            Route::post("/update", 'DashboardController@pricingEditPost')->name('pricingEditPost');
            Route::delete("/delete/{id}", 'DashboardController@pricingDeletePost')->name('pricingDeletePost');
        });

        Route::group(['prefix' => 'website'], function () {
            Route::get("/posts/add", 'DashboardController@addPost')->name('addPost');
            Route::post("/posts/add", 'DashboardController@postAddPost')->name('postAddPost');
            Route::get("/posts", 'DashboardController@allPosts')->name('allPosts');
            Route::get("/posts/edit/{id}", 'DashboardController@postEdit')->name('postEdit');
            Route::post("/posts/update", 'DashboardController@postEditPost')->name('postEditPost');
            Route::delete("/posts/delete/{id}", 'DashboardController@postDeletePost')->name('postDeletePost');

            Route::get("/category/add", 'DashboardController@addCategory')->name('addCategory');
            Route::post("/category/add", 'DashboardController@categoryAddPost')->name('categoryAddPost');
            Route::get("/category", 'DashboardController@allCategory')->name('allCategory');
            Route::get("/category/edit/{id}", 'DashboardController@categoryEdit')->name('categoryEdit');
            Route::post("/category/update", 'DashboardController@categoryEditPost')->name('categoryEditPost');
            Route::delete("/category/delete/{id}", 'DashboardController@categoryDeletePost')->name('categoryDeletePost');


            Route::get("/terms-and-conditions", 'DashboardController@termsAndConditions')->name('termsAndConditions');
            Route::post("/terms-and-conditions", 'DashboardController@termsAndConditionsPost')->name('termsAndConditionsPost');

            Route::get("/privacy-policy", 'DashboardController@privacyPolicy')->name('privacyPolicy');
            Route::post("/privacy-policy", 'DashboardController@privacyPolicyPost')->name('privacyPolicyPost');

            Route::get("/cookie-policy", 'DashboardController@cookiePolicy')->name('cookiePolicy');
            Route::post("/cookie-policy", 'DashboardController@cookiePolicyPost')->name('cookiePolicyPost');
        });
    });
});

