@extends('index.layouts.app')

@section('title','发现')

@section('css')
    <link rel="stylesheet" href="/css/index/find.css">
@endsection

@section('content')
    <div class="large">
        <div class="findbackground">

        </div>
        <div class="contact">
            <h3 class="text-center" style="color: orange">联系我们</h3>
            <p class="text-center" style="color: orange">长按识别二维码添加客服</p>
            <div class="code">
                <img src="static/index/find/code.jpg" style="width: 100px" alt="">
            </div>
            <p class="tuijian">{{ $content['recommend'] }}</p>

            <p class="kefu">{{ $content['server'] }}</p>
            <hr class="fenge" />

            <div class="notice">
                <div class="notice-title">
                    注意：
                </div>
                <div class="notice-content">
                        {!! $content['notice'] !!}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')

@endsection