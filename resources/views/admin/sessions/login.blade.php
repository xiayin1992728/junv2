@include('admin.layouts._meta')
<meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="login-bg">
<div class="login layui-anim layui-anim-up">
    <div class="message">后台管理</div>
    <div id="darkbannerwrap"></div>
    <form method="post" class="layui-form" >
        <input name="phone" placeholder="手机号"  type="text" lay-verify="required" class="layui-input" >
        <hr class="hr15">
        <input name="password" lay-verify="required" placeholder="密码"  type="password" class="layui-input">
        <hr class="hr15">
        <input value="登录" lay-submit lay-filter="login" style="width:100%;" type="submit">
        <hr class="hr20" >
    </form>
</div>
@include('admin.layouts._footer')
<script>
    $(function  () {
        layui.use('form', function(){
            var form = layui.form;
            form.on('submit(login)', function(data){
                console.log(data.field);
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                   url:"{{ route('session.store') }}",
                   type:'post',
                   data:data.field,
                   dataType:'json',
                   success:function(res) {
                       if (res.status == 200) {
                           location.href = "{{ route('admin.home') }}"
                       } else {
                           layer.msg(res.msg,{icon:5});
                       }
                   },
                   errors:function(res) {

                   }
                });
                return false;
            });
        });
    })
</script>
<!-- 底部结束 -->
</body>
</html>