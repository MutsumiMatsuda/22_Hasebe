<?php

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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function() {
    Route::get('news/create', 'Admin\NewsController@add');
    Route::post('news/create', 'Admin\NewsController@create'); # 追記
    Route::get('news', 'Admin\NewsController@index'); // 追記
    Route::get('news/edit', 'Admin\NewsController@edit'); // 追記
    Route::post('news/edit', 'Admin\NewsController@update'); // 追記
    Route::get('news/delete', 'Admin\NewsController@delete');
    // PHP/Laravel 10 課題4 関数を追加
    Route::get('profile/create', 'Admin\ProfileController@add');
    Route::post('profile/create', 'Admin\ProfileController@create'); # PHP/Laravel 14 課題3 追記
    Route::get('profile/edit', 'Admin\ProfileController@edit');
    Route::post('profile/edit', 'Admin\ProfileController@update'); # PHP/Laravel 14 課題6 追記
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/info', function () {
    phpinfo();
});

Route::get('/', 'NewsController@index');
