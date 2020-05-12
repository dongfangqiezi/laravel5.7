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
//Route::get('/users/{user}/edit', 'UsersController@edit')->name('users.edit');
//Route::get('/index');

/**
 * 用户登录处理
 */
//  用户登录界面
Route::get('/login', 'SessionsController@create')->name('login');
//  创建新会话(登录)
Route::post('/login', 'SessionsController@store')->name('login');
//  销毁会话(退出登录)
Route::delete('/logout', 'SessionsController@destroy')->name('logout');

//  用户邮箱激活
Route::get('signup/confirm/{token}', 'UsersController@confirmEmail')->name('confirm_email');

/**
 * 用户密码重设
 */
//  显示重置密码的邮箱发送页面
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
//  邮箱发送重设链接
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
//  密码更新页面
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
//  执行密码更新操作
Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');

/**
 * 发布微博
 */
Route::resource('statuses', 'StatusesController', [ 'only' => ['store', 'destroy'] ]);