<?php

use App\Http\Controllers\Apps\AppPageController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix'=>'apps','as'=>'Apps.', 'middleware'=>'onlyLogins'], function(){
    Route::get('/', [AppPageController::class, 'index'])->name('index');
    Route::get('/{first}/', [AppPageController::class, 'oneAppSelected'])->name('oneAppSelected');
    Route::get('/{first}/{second}', [AppPageController::class, 'twoAppsSelected'])->name('twoAppsSelected');
});
Route::group(['prefix'=>'zaps','as'=>'Apps.', 'middleware'=>'onlyLogins'], function(){
    Route::get('/', [AppPageController::class, 'zaps'])->name('zaps');
    Route::get('/zaps/details/{id}/{type}', [AppPageController::class, 'zapsDetails'])->name('zapsDetails');
});
