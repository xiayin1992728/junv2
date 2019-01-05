@include('admin.layouts._meta')
<meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
<div class="x-body">
    <form class="layui-form">
        <div class="layui-form-item">
            <label for="username" class="layui-form-label">
                <span class="x-red">*</span>用户名
            </label>
            <div class="layui-input-inline">
                <input type="text" id="username" name="name" required="" lay-verify="required"
                       autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label for="phone" class="layui-form-label">
                <span class="x-red">*</span>手机
            </label>
            <div class="layui-input-inline">
                <input type="text" id="phone" name="phone" required="" lay-verify="phone"
                       autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label"><span class="x-red">*</span>角色</label>
            <div class="layui-input-block">
                @foreach($roles as $role)
                    <input type="checkbox" name="roles[]" lay-skin="primary" value="{{ $role->name }}" title="{{ $role->name }}">
                @endforeach
            </div>
        </div>
        <div class="layui-form-item">
            <label for="L_pass" class="layui-form-label">
                <span class="x-red">*</span>密码
            </label>
            <div class="layui-input-inline">
                <input type="password" id="L_pass" name="password" required="" lay-verify="pass"
                       autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label for="L_repass" class="layui-form-label">
            </label>
            <button  class="layui-btn" lay-filter="add" lay-submit="">
                添加
            </button>
        </div>
    </form>
</div>
@include('admin.layouts._footer')
<script>
    layui.use(['form','layer'], function(){
        $ = layui.jquery;
        var form = layui.form
            ,layer = layui.layer;
        //监听提交
        form.on('submit(add)', function(data){
            console.log(data);
            //发异步，把数据提交给php
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
               url: "{{ route('admin.store') }}",
               type: 'post',
               data:data.field,
               dataType: 'json',
               success:function (res) {
                   console.log(res);
                    if (res.status == 200) {
                        layer.msg(res.msg,{icon:6});
                        setTimeout(function(){
                            // 获得frame索引
                            var index = parent.layer.getFrameIndex(window.name);
                            //关闭当前frame
                            parent.layer.close(index);
                        },2000);
                    } else {
                        layer.msg(res.msg,{icon:5});
                    }
               },
               error:function (res,textStatus) {
                   console.log(res);
                   res = res.responseJSON;
                    if (res.errors != undefined) {
                        if (res.errors.phone != undefined) {
                            layer.msg(res.errors.phone[0],{icon:5});
                        } else if (res.errors.name != undefined) {
                            layer.msg(res.errors.name[0],{icon:5});
                        } else if (res.errors.roles != undefined) {
                            layer.msg(res.errors.roles[0],{icon:5});
                        } else if (res.errors.password != undefined) {
                            layer.msg(res.errors.password[0],{icon:5});
                        }
                    }
               }
            });
            return false;
        });
    });
</script>
</body>

</html>