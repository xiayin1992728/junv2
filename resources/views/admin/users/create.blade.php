@include('admin.layouts._meta')
<meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
<div class="x-body">
    <form class="layui-form">
        <div class="layui-form-item">
            <label for="username" class="layui-form-label">
                姓名
            </label>
            <div class="layui-input-inline">
                <input type="text" id="username" name="name"
                       autocomplete="off" class="layui-input">
            </div>

            <label for="phone" class="layui-form-label">
                <span class="x-red">*</span>手机
            </label>
            <div class="layui-input-inline">
                <input type="text" id="phone" name="phone" required="" lay-verify="phone"
                       autocomplete="off" class="layui-input">
            </div>

            <label for="L_pass" class="layui-form-label">
                身份证
            </label>
            <div class="layui-input-inline">
                <input type="number" id="L_pass" name="idcard"
                       autocomplete="off" class="layui-input">
            </div>
        </div>



        <div class="layui-form-item">
            <label for="L_pass" class="layui-form-label">
                芝麻分
            </label>
            <div class="layui-input-inline">
                <input type="number" id="L_pass" name="credit"
                       autocomplete="off" class="layui-input">
            </div>

            <label for="L_pass" class="layui-form-label">
                微信号
            </label>
            <div class="layui-input-inline">
                <input type="text" id="L_pass" name="weixin"
                       autocomplete="off" class="layui-input">
            </div>

            <label for="L_pass" class="layui-form-label">
                QQ号
            </label>
            <div class="layui-input-inline">
                <input type="number" id="L_pass" name="qq"
                       autocomplete="off" class="layui-input">
            </div>
        </div>

        <div class="layui-form-item">
            <label for="L_pass" class="layui-form-label">
                房
            </label>
            <div class="layui-input-inline">
                <input type="radio" name="house" value="1" title="有">
                <input type="radio" name="house" value="0" title="无" checked>
            </div>

            <label for="L_pass" class="layui-form-label">
                公积金
            </label>
            <div class="layui-input-inline">
                <input type="radio" name="accumulation" value="1" title="有">
                <input type="radio" name="accumulation" value="0" title="无" checked>
            </div>

            <label for="L_pass" class="layui-form-label">
                车
            </label>
            <div class="layui-input-inline">
                <input type="radio" name="card" value="1" title="有">
                <input type="radio" name="card" value="0" title="无" checked>
            </div>
        </div>


        <div class="layui-form-item">
            <label for="L_pass" class="layui-form-label">
                工作
            </label>
            <div class="layui-input-inline">
                <input type="radio" name="work" value="1" title="有">
                <input type="radio" name="work" value="0" title="无" checked>
            </div>

            <label for="L_pass" class="layui-form-label">
                社保
            </label>
            <div class="layui-input-inline">
                <input type="radio" name="insurance" value="1" title="有">
                <input type="radio" name="insurance" value="0" title="无" checked>
            </div>

            <label for="L_pass" class="layui-form-label">
                <span class="x-red">*</span>关联推广者
            </label>
            <div class="layui-input-inline">
                <select lay-verify="required" lay-filter="uid" name="uid" id="uid">
                    <option value="" selected>请选择</option>
                    @foreach ($admins as $admin)
                        <option value="{{ $admin->id }}">{{ $admin->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="layui-form-item" id="product">
            <label for="L_pass" class="layui-form-label">
                <span class="x-red">*</span>关联推广者推广产品
            </label>
            <div class="layui-input-inline">
                <select name="sid" lay-verify="required">

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
                url: "{{ route('user.store') }}",
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
                        } else if (res.errors.sid != undefined) {
                            layer.msg(res.errors.sid[0],{icon:5});
                        }
                    }
                }
            });
            return false;
        });

        // 监听select
        form.on('select(uid)', function(data){
            console.log(data.elem); //得到select原始DOM对象
            console.log(data.value); //得到被选中的值
            console.log(data.othis); //得到美化后的DOM对象

            $.ajax({
                url: '/spreads/salesmanSpread/'+data.value,
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
                        } else if (res.errors.sid != undefined) {
                            layer.msg(res.errors.sid[0],{icon:5});
                        }
                    }
                }
            });
        });
    });
</script>
</body>
</html>