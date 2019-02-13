<!DOCTYPE html>
<html>
<head>
    <title>后台登陆</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords"
          content="Flat Dark Web Login Form Responsive Templates, Iphone Widget Template, Smartphone login forms,Login form, Widget Template, Responsive Templates, a Ipad 404 Templates, Flat Responsive Templates"/>
    <!--webfonts-->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="/css/admin/style.css">
    <!--//webfonts-->
    <script src="/layui/js/jquery.min.js"></script>
</head>
<body>
<!--SIGN UP-->
<h1>钱富贵后台登陆</h1>
<div class="login-form">
    <div class="close"></div>
    <div class="head-info">
        <label class="lbl-1"> </label>
        <label class="lbl-2"> </label>
        <label class="lbl-3"> </label>
    </div>
    <div class="clear"></div>
    <div class="avtar">
        <img src="/static/admin/login/avtar.png"/>
    </div>
    <form>
        <input type="text" id="phone" class="text" value="" placeholder="请输入手机号">
        <div class="key">
            <input type="password" id="password" value="" placeholder="请输入密码">
        </div>
    </form>
    <div class="signin">
        <input type="submit" id="singin" value="登陆">
    </div>
</div>
</body>
</html>
<script>
    $('#singin').on('click',function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        let data = {phone:$('#phone').val(),password:$('#password').val()};
        $.ajax({
            url: "{{ route('session.store') }}",
            type: 'post',
            data: data,
            dataType: 'json',
            success: function (res) {
                if (res.status == 200) {
                    location.href = "{{ route('admin.home') }}"
                } else {
                    alert(res.msg);
                }
            },
            errors: function (res) {

            }
        });
    });

    if (window != top) {
        top.location.href = window.location.href;
    }
</script>
<!-- 底部结束 -->
