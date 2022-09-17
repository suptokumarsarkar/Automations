<?php

use Illuminate\Support\Facades\Route;
Route::get('register', 'Api/V1/Auth/CustomerAuthController@registration');