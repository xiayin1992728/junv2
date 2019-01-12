@include('admin.layouts._meta')
<meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
<div class="x-body">
    <form class="layui-form">
        <div class="layui-form-item">
            <label for="name" class="layui-form-label">
                渠道名称
            </label>
            <div class="layui-input-inline">
                <input type="text" id="name" name="name"
                       autocomplete="off" class="layui-input" lay-verify="required">
            </div>
        </div>


        <div class="layui-form-item">
            <label for="name" class="layui-form-label">
                公司名称
            </label>
            <div class="layui-input-inline">
                <input type="text" id="name" name="company"
                       autocomplete="off" class="layui-input" lay-verify="required">
            </div>
        </div>

        <div class="layui-form-item">
            <label for="longtimes" class="layui-form-label">
                结算方式
            </label>
            <div class="layui-input-inline">
                <select name="types" lay-verify="required">
                    <option value="">选择结算方式</option>
                    <option value="微信支付">微信支付</option>
                    <option value="支付宝支付">支付宝支付</option>
                    <option value="其他">其他</option>
                </select>
            </div>
        </div>

        <div class="layui-form-item">
            <label for="status" class="layui-form-label">
                所属推广者
            </label>
            <div class="layui-input-inline">
                <select name="uid" lay-verify="required">
                    <option value="">选择属于哪个推广者</option>
                    @foreach($admins as $admin)
                        <option value="{{ $admin->id }}">{{ $admin->name }}</option>
                    @endforeach
                </select>
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

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        //监听提交
        form.on('submit(add)', function(data){
            console.log(data);
            //发异步，把数据提交给php
            $.ajax({
                url: "{{ route('channels.store') }}",
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
                            // 刷新页面
                            parent.window.location.href = parent.window.location.href;
                        },2000);
                    } else {
                        layer.msg(res.msg,{icon:5});
                    }
                },
                error:function (res,textStatus) {
                    console.log(res);
                    res = res.responseJSON;
                    if (res.errors != undefined) {
                        let field = ['name','types','uid'];
                        makeError(field,res.errors);
                    }
                }
            });
            return false;
        });

        function makeError(field,data) {
            let len = field.length;
            for (var i=0;i<len;i++) {
                if (data[field[i]] != undefined) {
                    layer.msg(data[field[i]][0],{icon:5});
                    break;
                }
            }
        }
    });
</script>
</body>
</html>