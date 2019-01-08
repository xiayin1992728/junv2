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
                       autocomplete="off" class="layui-input" value="{{ $user->name }}">
            </div>

            <label for="phone" class="layui-form-label">
                <span class="x-red">*</span>手机
            </label>
            <div class="layui-input-inline">
                <input type="text" id="phone" name="phone" required="" lay-verify="phone"
                       autocomplete="off" class="layui-input" value="{{ $user->phone }}">
            </div>

            <label for="L_pass" class="layui-form-label">
                身份证
            </label>
            <div class="layui-input-inline">
                <input type="number" id="L_pass" name="idcard"
                       autocomplete="off" class="layui-input" value="{{ $user->idcard }}">
            </div>
        </div>



        <div class="layui-form-item">
            <label for="L_pass" class="layui-form-label">
                芝麻分
            </label>
            <div class="layui-input-inline">
                <input type="number" id="L_pass" name="credit"
                       autocomplete="off" class="layui-input" value="{{ $user->credit }}">
            </div>

            <label for="L_pass" class="layui-form-label">
                微信号
            </label>
            <div class="layui-input-inline">
                <input type="text" id="L_pass" name="weixin"
                       autocomplete="off" class="layui-input" value="{{ $user->weixin }}">
            </div>

            <label for="L_pass" class="layui-form-label">
                QQ号
            </label>
            <div class="layui-input-inline">
                <input type="number" id="L_pass" name="qq"
                       autocomplete="off" class="layui-input" value="{{ $user->qq }}">
            </div>
        </div>

        <div class="layui-form-item">
            <label for="L_pass" class="layui-form-label">
                房
            </label>
            <div class="layui-input-inline">
                @if ($user->house)
                    <input type="radio" name="house" value="1" title="有" checked>
                    <input type="radio" name="house" value="0" title="无">
                @else
                    <input type="radio" name="house" value="1" title="有">
                    <input type="radio" name="house" value="0" title="无" checked>
                @endif
            </div>

            <label for="L_pass" class="layui-form-label">
                公积金
            </label>
            <div class="layui-input-inline">
                @if($user->accumulation)
                <input type="radio" name="accumulation" value="1" title="有" checked>
                <input type="radio" name="accumulation" value="0" title="无" >
                @else
                    <input type="radio" name="accumulation" value="1" title="有">
                    <input type="radio" name="accumulation" value="0" title="无" checked>
                @endif
            </div>

            <label for="L_pass" class="layui-form-label">
                车
            </label>
            <div class="layui-input-inline">
                @if ($user->card)
                    <input type="radio" name="card" value="1" title="有" checked>
                    <input type="radio" name="card" value="0" title="无">
                @else
                    <input type="radio" name="card" value="1" title="有">
                    <input type="radio" name="card" value="0" title="无" checked>
                @endif
            </div>
        </div>


        <div class="layui-form-item">
            <label for="L_pass" class="layui-form-label">
                工作
            </label>
            <div class="layui-input-inline">
                @if ($user->work)
                <input type="radio" name="work" value="1" title="有" checked>
                <input type="radio" name="work" value="0" title="无">
                @else
                    <input type="radio" name="work" value="1" title="有">
                    <input type="radio" name="work" value="0" title="无" checked>
                @endif
            </div>

            <label for="L_pass" class="layui-form-label">
                社保
            </label>
            <div class="layui-input-inline">
                @if ($user->insurance)
                <input type="radio" name="insurance" value="1" title="有" checked>
                <input type="radio" name="insurance" value="0" title="无">
                @else
                    <input type="radio" name="insurance" value="1" title="有">
                    <input type="radio" name="insurance" value="0" title="无" checked>
                @endif
            </div>

            <label for="L_pass" class="layui-form-label">
                <span class="x-red">*</span>关联推广者
            </label>
            <div class="layui-input-inline">
                <select name="sid" lay-verify="required">
                    <option value="">请选择</option>
                    @foreach ($admins as $admin)
                        @if($admin->id === $user->sid)
                            <option value="{{ $admin->id }}" selected>{{ $admin->name }}</option>
                        @else
                            <option value="{{ $admin->id }}">{{ $admin->name }}</option>
                        @endif
                    @endforeach
                </select>
            </div>
        </div>

        <div class="layui-form-item">
            <label for="L_repass" class="layui-form-label">
            </label>
            <button  class="layui-btn" lay-filter="add" lay-submit="">
                修改
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
                url: "{{ route('user.update',['id' => $user->id]) }}",
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
    });
</script>
</body>

</html>