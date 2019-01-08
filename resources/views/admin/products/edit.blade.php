@include('admin.layouts._meta')
<meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
<div class="x-body">
    <form class="layui-form">
        <div class="layui-form-item">
            <label for="name" class="layui-form-label">
                产品名称
            </label>
            <div class="layui-input-inline">
                <input type="text" id="name" name="name"
                     value="{{ $product->name }}"  autocomplete="off" class="layui-input">
            </div>

            <label for="maxs" class="layui-form-label">
                <span class="x-red">*</span>最大额度
            </label>
            <div class="layui-input-inline">
                <input type="text" id="maxs" name="maxs" required=""
                  value="{{ $product->maxs }}"     autocomplete="off" class="layui-input">
            </div>

            <label for="tag" class="layui-form-label">
                标签
            </label>
            <div class="layui-input-inline">
                <input type="text" id="tag" name="tag"
                  value="{{ $product->tag }}"     autocomplete="off" class="layui-input">
            </div>
        </div>

        <div class="layui-form-item">
            <label for="longtimes" class="layui-form-label">
                借款期限
            </label>
            <div class="layui-input-inline">
                <input type="number" id="longtimes" name="longtimes"
                 value="{{ $product->longtimes }}"      autocomplete="off" class="layui-input">
            </div>

            <label for="link" class="layui-form-label">
                产品链接
            </label>
            <div class="layui-input-inline">
                <input type="text" id="link" name="link"
                    value="{{ $product->link }}"   autocomplete="off" class="layui-input">
            </div>

            <label for="saleman" class="layui-form-label">
                产品业务员
            </label>
            <div class="layui-input-inline">
                <input type="text" id="saleman" name="saleman"
                  value="{{ $product->saleman }}"     autocomplete="off" class="layui-input">
            </div>
        </div>

        <div class="layui-form-item">
            <label for="status" class="layui-form-label">
                产品状态
            </label>
            <div class="layui-input-inline">
                @if ($product->status)
                    <input type="radio" name="status" value="1" title="上架" checked>
                    <input type="radio" name="status" value="0" title="下架">
                @else
                    <input type="radio" name="status" value="1" title="上架">
                    <input type="radio" name="status" value="0" title="下架" checked>
                @endif
            </div>

            <label for="status" class="layui-form-label">
                产品类型
            </label>
            <div class="layui-input-inline">
                @if ($product->types == '外部产品')
                    <input type="radio" name="types" value="外部产品" title="外部" checked>
                    <input type="radio" name="types" value="内部产品" title="内部">
                @else
                    <input type="radio" name="types" value="外部产品" title="外部">
                    <input type="radio" name="types" value="内部产品" title="内部" checked>
                @endif
            </div>

        </div>

        <div class="layui-form-item">
            <label for="L_pass" class="layui-form-label">
                产品 logo
            </label>
            <div class="layui-input-inline">
                <button type="button" class="layui-btn" id="logo">
                    <i class="layui-icon">&#xe67c;</i>上传图片
                </button>
            </div>

            <div class="layui-input-inline" id="logo-thumb">
                <img src="{{ config('app.url').$product->logo }}" alt="" style="width: 100px;height: 100px;">
            </div>
            <input type="hidden" value="{{ $product->logo }}" name="logo" id="logo_thumb">
        </div>
        <input type="hidden" name="id" value="{{ $product->id }}">
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
    layui.use(['form','layer','upload'], function(){
        $ = layui.jquery;
        var form = layui.form
            ,layer = layui.layer;
        var upload = layui.upload;

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        //执行实例
        var uploadInst = upload.render({
            elem: '#logo', //绑定元素
            url: "{{ route('admin.products.logo') }}", //上传接口
            type: "post",
            done: function(res){
                if (res.status) {
                    $('#logo-thumb img').attr('src',"{{ config('app.url') }}"+res.path);
                    $('#logo-thumb').show();
                    $('#logo_thumb').val(res.path);
                } else {
                    layer.msg(res.msg,{icon:5});
                }
            }
            ,error: function(){
                //请求异常回调
            }
        });

        //监听提交
        form.on('submit(add)', function(data){
            console.log(data);
            //发异步，把数据提交给php
            $.ajax({
                url: "{{ route('products.update',['id' => $product->id]) }}",
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
                            // 刷新页面
                            parent.window.location.href = "{{ route('products.index') }}";
                        },2000);
                    } else {
                        layer.msg(res.msg,{icon:5});
                    }
                },
                error:function (res,textStatus) {
                    console.log(res);
                    res = res.responseJSON;
                    if (res.errors != undefined) {
                        let field = ['name','logo','maxs','tag','longtimes','link','saleman','types'];
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