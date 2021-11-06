<?php

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

Route::group(['namespace' => 'Api'], function (){
    Route::group(['prefix' => 'category'], function (){
        Route::get('/all-list','CategoryController@allList');
        Route::get('/blog-with-list','CategoryController@blogWithList');
    });

    Route::group(['prefix' => 'blog'], function (){
        Route::get('/slider-list','BlogController@homeSliderList');
    });
});
