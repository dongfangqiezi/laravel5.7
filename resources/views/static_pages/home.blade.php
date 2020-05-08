@extends("layouts.default")
@section("title", "动如雷霆")

@section("content")
<div class="jumbotron">
    <h1>静水流深</h1>
    <p class="lead">
         <a href="http://dongfangqiezi.top">大风起焉云飞扬</a>
    </p>
    <p>
        浅水是喧哗的，深水是沉默的。
    </p>
    <p>
        <a class="btn btn-lg btn-success" href="{{route('signup')}}" role="button">现在注册</a>
    </p>
</div>
@stop