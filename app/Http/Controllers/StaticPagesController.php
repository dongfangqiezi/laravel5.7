<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Status;
use Illuminate\Support\Facades\Auth;

class StaticPagesController extends Controller
{
    //
    public function home(){
        //  定义一个空数组
        $feed_items = [];
        //  j检测用户是否登录，如果登录 将若干条博文赋值给$feed_items
        if (Auth::check()) $feed_items = Auth::user()->feed()->paginate(5);

        return view('static_pages/home', compact('feed_items'));
    }
    
    public function help(){
        return view("static_pages/help");
    }

    public function about(){
        return view("static_pages/about");
    }
}
