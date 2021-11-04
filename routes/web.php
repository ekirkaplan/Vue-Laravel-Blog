<?php

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

Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix' => 'panel','namespace' => 'Backend','as' => 'panel.'], function (){
    Route::group(['prefix' => 'auth','as' => 'auth.'], function (){
        Route::get('/login','AuthController@loginIndex')->name('login.index');
        Route::post('/login-process','AuthController@loginProcess')->name('login.process');
    });

    Route::group(['middleware' => 'AdminMiddleware'], function (){
        Route::get('/','HomeController@index')->name('home.index');
        Route::get('/auth/logout','AuthController@logout')->name('auth.logout');
    });
});
