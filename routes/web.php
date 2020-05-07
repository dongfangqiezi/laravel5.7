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

//  静态页面路由

//use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Route;



Route::get("/", "StaticPagesController@home")->name('home');
Route::get("/help", "StaticPagesController@help")->name('help');
Route::get("/about", "StaticPagesController@about")->name('about');

//  用户注册路由
Route::get("/signup", "UsersController@create")->name('signup');

//  RESTful用户资源路由
Route::resource('/users', 'UsersController');
//Route::get('/users/{user}', 'UsersController@show')->name('users.show');

/**
 * 用户登录处理
 */
//  用户登录界面
Route::get('/login', 'SessionsController@create')->name('login');
//  创建新会话(登录)
Route::post('/login', 'SessionsController@store')->name('login');
//  销毁会话(退出登录)
Route::delete('/logout', 'SessionsController@destroy')->name('logout');