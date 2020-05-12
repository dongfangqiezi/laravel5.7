<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Status;
use Illuminate\Support\Facades\Auth;

class StatusesController extends Controller
{
    //  构造函数，访问限制
    function __construct()
    {
        //  
        $this->middleware('auth');
    }
    
    //  创建微博页面
    public function show(int $var = 1)
    {
        # code...
    }

    //  创建微博动作
    public function store(Request $request)
    {
        //  验证规则
        $this->validate($request, [
            'content' => 'required|max:140',
        ]);

        //  当前用户创建博文
        Auth::user()->statuses()->create([
            'content' => $request['content']
        ]);

        //  反馈用户信息，重定向页面
        session()->flash('success', '发布成功！');
        return redirect()->back();
    }
}
