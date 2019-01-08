@include('admin.layouts._meta')
<meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
<div class="x-body">
    <form action="" method="post" class="layui-form layui-form-pane">
        <div class="layui-form-item">
            <label for="name" class="layui-form-label">
                <span class="x-red">*</span>角色名
            </label>
            <div class="layui-input-inline">
                <input type="text" id="name" name="name" required="" lay-verify="required"
                       autocomplete="off" class="layui-input" value="{{ $role->name }}">
            </div>
        </div>
        <div class="layui-form-item layui-form-text">
            <label class="layui-form-label">
                拥有权限
            </label>
            <table  class="layui-table layui-input-block">
                <tbody>
                <tr>
                    <td>
                        <div class="layui-input-block">
                            @foreach ($permissions as $permission)
                                @if (in_array($permission->name,$rolesHasPermissions))
                                    <input name="permissions[]" value="{{ $permission->name }}" lay-skin="primary" checked type="checkbox" title="{{ $permission->name }}" value="2">
                                @else
                                    <input name="permissions[]" value="{{ $permission->name }}" lay-skin="primary" type="checkbox" title="{{ $permission->name }}" value="2">
                                @endif
                            @endforeach
                        </div>
                    </td>

                </tr>
                </tbody>
            </table>
        </div>
        <div class="layui-form-item">
            <button class="layui-btn" lay-submit="" lay-filter="add">修改</button>
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
            data.field.id = "{{ $role->id }}";
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{ route('roles.update',['id' => $role->id]) }}",
                type: 'put',
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
                        if (res.errors.name != undefined) {
                            layer.msg(res.errors.name[0],{icon:5});
                        } else if (res.errors.permissions != undefined) {
                            layer.msg(res.errors.permissions[0],{icon:5});
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