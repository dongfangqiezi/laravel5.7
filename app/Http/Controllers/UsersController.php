<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use function GuzzleHttp\Promise\all;

/**
 * 用户注册登录
 */
class UsersController extends Controller
{

    //  auth 过滤中间件
    public function __construct()
    {
        //  这几个动作不使用auth过滤器，允许未登录用户查看
        $this->middleware('auth', [
            'except' => ['create', 'show', 'store', 'index'],
        ]);

        //  只允许未登录用户访问注册页面
        $this->middleware('guest', [
            'only' => ['create']
        ]);
    }

    //  所有用户数据信息
    public function index(User $user)
    {
        //  分页
        $users = User::paginate(10);
        return view('users.index', compact('users'));
    }

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
        //权限验证
        $this->authorize('update', $user);

        return view('users.edit', compact('user'));
    }

    //  更改用户资料操作
    public function update(User $user, Request $request)
    {
        //权限验证
        $this->authorize('update', $user);

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

        //  如果用户更改密码与原密码相同，则拒绝更新请求并提示
        //  if($request->password==$user->password) exit( session()->flash('danger', '修改密码不能与原密码相同！') );
        //  Hash::check() 两者相等 true, 反之false
        if( Hash::check( $request->input('password'), Auth()->user()->password ) ) {
            session()->flash('danger', '与旧密码相同！');
            return redirect()->back();
        }

        //  如果用户不想更新密码 不输入密码那一项。那么$request->password只有不为空时才会赋值给$data
        if($request->password){
            $data['password'] = bcrypt($request->password);
        }

        //  执行更新操作
        $user->update($data);

        //  闪存 向用户反馈信息
        session()->flash('success', '个人资料更新成功！');

        //  跳转至用户信息展示界面
        return redirect()->route('users.show', $user->id);
    }
}
