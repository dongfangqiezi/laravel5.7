<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SessionsController extends Controller
{
    //  权限设置
    public function __construct()
    {
        //  只允许未登录用户访问注册页面
        $this->middleware('guest', [
            'only' => ['create']
        ]);
    }

    //  create
    public function create()
    {
        return view('sessions.create');
    }

    //  store   登录逻辑处理
    public function store(Request $request)
    {
        //  验证用户输入信息是否合法
        $credentials = $this->validate($request, [
            'email' => 'required|email|max:255',
            'password' => 'required'
        ]);
        
        //  该用户存在于数据库，且邮箱和密码相符合
        //  根据邮箱在数据库中查找用户，如果查找到且密码的哈希值与数据库中的哈希值相匹配，那么就登录成功，反之失败。
        if (Auth::attempt($credentials, $request->has('remeber'))) {
            if(Auth::user()->activated) {
                session()->flash('success', '欢迎回来！');
                //  使用 Auth::user() 方法获取用户信息传递给路由
                $fallback = route('users.show', Auth::user());
                return redirect()->intended($fallback);
            } else {
                Auth::logout();
                session()->flash('warning', '你的账号未激活，请检查邮箱中的注册邮件进行激活。');
                return redirect('/');
            }
           
        } else {
            session()->flash('danger', '很抱歉，您的邮箱和密码不匹配！');
            //  使用 withInput()  后模板里old('email')  将能获取到上一次用户提交的内容，这样用户就无需再次输入邮箱等内容
            return redirect()->back()->withInput();
        }
    }

    //  destroy 用户退出处理
    public function destroy()
    {
        Auth::logout();
        session()->flash('success', '您已成功退出！');
        return redirect('login');
    }
}
