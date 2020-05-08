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

    //  更改用户资料页面
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    //  更改用户资料操作
    public function update(User $user, Request $request)
    {
        //  验证数据合法性
        $this->validate($request, [
            //  验证规则
            'name' => 'required|max:50',
            'password' => 'nullable|confirmed|min:6'
        ]);

        // //  执行数据库更新操作
        // $user->update([
        //     'name' => $request->name,
        //     'password' => bcrypt($request->password),
        // ]);
        
        //  定义一个空数组
        $data = [];
        $data['name'] = $request->name;

        //  如果用户不想更新密码 不输入密码那一项。那么$request->password只有不为空时才会赋值给$data
        if($request->password){
            $data['password'] = $request->password;
        }

        //  执行更新操作
        $user->update($data);

        //  闪存 向用户反馈信息
        session()->flash('success', '个人资料更新成功！');

        //  跳转至用户信息展示界面
        return redirect()->route('users.show', $user->id);
    }
}
