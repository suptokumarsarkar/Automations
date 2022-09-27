<?php

use App\Http\Controllers\Api\Auth\FacebookAuth;
use App\Http\Controllers\Api\Auth\GoogleAuth;
use App\Http\Controllers\Api\Auth\MicrosoftAuth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('google-login',[GoogleAuth::class, 'login'])->name('GoogleLogin');
Route::post('session/sideBar',[\App\Http\Controllers\Api\Session\SessionController::class, 'sideBar'])->name('session.sideBar');

Route::post('google-token',[GoogleAuth::class, 'createProfile'])->name('googleToken');


Route::post('facebook-login',[FacebookAuth::class, 'login'])->name('FacebookLogin');
Route::post('microsoft-login',[MicrosoftAuth::class, 'login'])->name('MicrosoftLogin');


Route::get('apps', [\App\Http\Controllers\Api\Apps\Manager::class, 'getApps'])->name('getApps');
Route::post('getApp', [\App\Http\Controllers\Api\Apps\Manager::class, 'getApp'])->name('getApp');

Route::post('getExtraDataFields', [\App\Http\Controllers\Api\Apps\Manager::class, 'getExtraDataField'])->name('getExtraDataField');
Route::post('getExtraDataFields/{id}/{app}', [\App\Http\Controllers\Api\Apps\Manager::class, 'getExtraDataFields'])->name('getExtraDataFields');
Route::post('create-app', [\App\Http\Controllers\Api\Apps\Manager::class, 'createApp'])->name('createApp');
Route::post('check-trigger', [\App\Http\Controllers\Api\Apps\Manager::class, 'checkTrigger'])->name('checkTrigger');
Route::post('get-action-form', [\App\Http\Controllers\Api\Apps\Manager::class, 'getActionForm'])->name('getActionForm');
Route::post('create-zap', [\App\Http\Controllers\Api\Apps\Manager::class, 'createZap'])->name('createZap');
Route::post('publish-zap', [\App\Http\Controllers\Api\Apps\Manager::class, 'publishZap'])->name('publishZap');

Route::get('run-zap', [\App\Http\Controllers\Api\Apps\RunZap::class, 'runZap'])->name('runZap');


Route::group(['prefix'=>'master'], function(){
    Route::post("/getAccounts", [\App\Http\Controllers\Api\Apps\ConnectorLightNit::class, 'getAccounts'])->name('getAccounts');
});

Route::group(['prefix'=>'endpoints'], function(){
    Route::post("/gmail", [App\Apps\Gmail::class, 'StoreGmail']);
});
