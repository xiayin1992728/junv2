@extends('index.layouts.app')

@section('title','等待审核')

@section('css')
    <link rel="stylesheet" href="/css/index/continue.css">
@endsection

@section('content')
    <div class="large">
        <div class="top">
            <p>您当前的信用分值为 718 分</p>
            <p>恭喜你初审<strong style="color:#F49417">已通过</strong></p>
        </div>
        <div class="middle">

        </div>

        <div class="footer">
            <input type="submit" id="continue" value="复审中请等待">
            <p class="text-center">审核结果我们会用短信方式提示你</p>
        </div>
    </div>
@endsection

@section('script')

@endsection