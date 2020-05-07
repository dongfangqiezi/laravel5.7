<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    //  用户注册验证和数据载入数据库
    public function store(Request $request)
    {
        //  验证注册信息是否合法
        $this->validate($request, [
            'name' => 'required|max:50',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|confirmed|min:6'
        ]);
        
        //  写入数据库
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);
        
        Auth::login($user);
        session()->flash('sucess', '欢迎，加入侠隐阁大家庭~');
        return redirect()->route('users.show', [$user]);
    }
}
