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
Route::get("/", "StaticPagesController@home")->name('home');
Route::get("/help", "StaticPagesController@help")->name('help');
Route::get("/about", "StaticPagesController@about")->name('about');

//  用户操作路由
Route::get("/signup", "UsersController@create")->name('signup');

//  RESTful用户资源路由
Route::resource('users', 'UsersController');
//Route::get('/users/{user}', 'UsersController@show')->name('users.show');
