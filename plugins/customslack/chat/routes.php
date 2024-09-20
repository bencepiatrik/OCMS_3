<?php

use Cms\Classes\Theme;
use Cms\Classes\Page;
use Cms\Classes\Controller;
use CustomSlack\Chat\Models\User;
use Illuminate\Support\Facades\Session;

Route::group(['middleware' => ['web']], function () {

    Route::post('register', 'CustomSlack\Chat\Controllers\AuthController@register');

    Route::post('login', 'CustomSlack\Chat\Controllers\AuthController@login');

    Route::get('logout', 'CustomSlack\Chat\Controllers\AuthController@logout');

  //  Route::get('profile', 'CustomSlack\Chat\Controllers\AuthController@profile');

});
