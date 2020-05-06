<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

/**
 * 用户注册登录
 */
class UsersController extends Controller
{
    //  用户注册
    public function create()
    {
        return view('users.create');
    }

    //  用户信息展示页
    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

}
