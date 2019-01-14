@extends('index.layouts.app')

@section('title','登录')

@section('css')
    <link rel="stylesheet" href="/css/index/login.css">
@endsection

@section('content')
    <div class="back">
        <img src="/static/index/login/background.jpg" alt="">
    </div>
    <div class="large">
        <div class="login-header">
            <h4>
                <span>自助申请</span>
                <span>操作简单</span>
            </h4>
            <div class="container-img">
                <div><img src="/static/index/login/1.jpg" alt=""></div>
                <div><img src="/static/index/login/arrow.jpg" alt=""></div>
                <div><img src="/static/index/login/2.png" alt=""></div>
                <div><img src="/static/index/login/arrow.jpg" alt=""></div>
                <div><img src="/static/index/login/3.png" alt=""></div>
                <div><img src="/static/index/login/arrow.jpg" alt=""></div>
                <div><img src="/static/index/login/4.jpg" alt=""></div>
            </div>
        </div>
        <div class="login-panel">
            <form action="{{ route('home.user.store') }}" method="POST">
                {{ csrf_field() }}

                @if ($errors->has('phone'))
                    <div class="form-group shu">
                        <input type="text" placeholder="{{ $errors->first('phone') }}" class="form-control inperror" id="phone" aria-describedby="inputSuccess2Status" name="phone" value="{{ old('phone') }}">
                    </div>
                @else
                    <div class="form-group shu">
                        <input type="text" placeholder="请输入手机号" class="form-control" id="phone" aria-describedby="inputSuccess2Status" name="phone" value="{{ old('phone') }}">
                    </div>
                @endif

                @if ($errors->has('captcha'))
                    <div class="form-group getCode">
                        <input type="text" placeholder="{{ $errors->first('captcha') }}" class="form-control inperror" id="captcha" aria-describedby="inputSuccess2Status" name="captcha">
                        <img src="{{ captcha_src('mini') }}" align="点击刷新校检码">
                    </div>
                @else
                    <div class="form-group getCode">
                        <input type="text" placeholder="请输入校检码" class="form-control" id="captcha" aria-describedby="inputSuccess2Status" name="captcha">
                        <img src="{{ captcha_src('mini') }}" align="点击刷新校检码">
                    </div>
                @endif

                @if ($errors->has('code'))
                    <div class="form-group getCode">
                        <input type="text" placeholder="{{ $errors->first('code') }}" class="form-control inperror" id="code" aria-describedby="inputSuccess2Status" name="code">
                        <button class="btn" type="button" id="captchabtn">获取验证码</button>
                    </div>
                @else
                    <div class="form-group getCode">
                        <input type="text" placeholder="请输入验证码" class="form-control" id="code" aria-describedby="inputSuccess2Status" name="code">
                        <button class="btn" type="button" id="captchabtn">获取验证码</button>
                    </div>
                @endif
                <input type="hidden" name="arg" value="{{ $arg }}">
                <input type="hidden" name="key" value="" id="key">
                <input type="submit" class="shenqi" value="立即申请">
            </form>
            <p class="text-center" style="font-size: 0.6em;margin-top: 2vh;color: #FF864C">点击"立即申请"即代表同意 《新用户注册协议》</p>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        let timer = 0;
        let sendStatus = false;
        let timerStatus;
        $('#captchabtn').on('click',function() {

            if ($('#phone').val() == '') {
                $('#phone').attr('placeholder','手机号不能为空');
                $('#phone').addClass('inperror');
                return;
            }
            if ($('#captcha').val() == '') {
                $('#captcha').attr('placeholder','图形验证码不能为空');
                $('#captcha').addClass('inperror');
                return;
            }
            if (timer > 0 && sendStatus) {
                return;
            }

            $.ajax({
                url:"{{ route('message') }}",
                type:'POST',
                dataType:'json',
                data:{
                    _token: $('meta[name=csrf-token]').attr("content"),
                    phone:$('#phone').val(),
                    captcha:$('#captcha').val()
                },
                success:function(res) {
                    if (res.errors != undefined) {

                        $("#code").attr('placeholder','未知错误请联系管理员!');
                        $("#code").addClass('inperror');
                        $('.getCode img').click();

                    } else {
                        $('#key').val(res.key);
                        localStorage.setItem('key',res.key);
                        $("#captchabtn").attr('disable',true);
                        timer = 60;
                        sendStatus = true;
                        // 调用计时器
                        setTime();
                    }
                },
                error:function (res) {
                    if (res.status == 422) {
                        console.log(res.status);
                        if (res.responseJSON.errors.captcha != undefined) {
                            $('#captcha').val('');
                            $('.getCode img').click();
                            $('#captcha').attr('placeholder',res.responseJSON.errors.captcha[0]);
                            $("#captcha").addClass('inperror');
                        }
                        if (res.responseJSON.errors.phone != undefined) {
                            $('#phone').val('');
                            $('#phone').attr('placeholder',res.responseJSON.errors.phone[0]);
                            $("#phone").addClass('inperror');
                            $('.getCode img').click();
                        }
                    }
                }
            })
        });

        $('.getCode img').on('click',function(){
            $(this).attr('src','captcha/mini?'+Math.random());
        });

        if (localStorage.getItem('key')) {
            $('#key').val(localStorage.getItem('key'));
        }

        function setTime() {
            if (timer > 0 && sendStatus) {
                timer--;
                $('#captchabtn').text(timer+'(s)');
                setTimeout(setTime,1000);
            } else {
                sendStatus = false;
                timer = 0;
                $('#captchabtn').text('获取验证码');
            }
        }

    </script>
@endsection
