@include('admin.layouts._meta')
<meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
<div class="x-body">
    <form class="layui-form">
        <div class="layui-form-item">
            <label for="name" class="layui-form-label">
                选择推广员
            </label>
            <div class="layui-input-block">
                <select name="uid" lay-verify="required" lay-search>
                    <option value="">选择推广员</option>
                    @foreach($admins as $admin)
                        @if ($admin->id == $spread->uid)
                            <option value="{{ $admin->id }}" selected>{{ $admin->name }}</option>
                        @else
                            <option value="{{ $admin->id }}">{{ $admin->name }}</option>
                        @endif
                    @endforeach
                </select>
            </div>
        </div>

        <div class="layui-form-item">
            <label for="status" class="layui-form-label">
                流水号
            </label>
            <div class="layui-input-block">
                <input type="text" id="name" name="number"
                     disabled value="{{ $spread->number }}"  autocomplete="off" class="layui-input" lay-verify="required">
            </div>
        </div>

        <div class="layui-form-item">
            <label for="status" class="layui-form-label">
                推广链接
            </label>
            <div class="layui-input-block">
                <input type="text" id="name" name="number"
                       disabled value="{{ config('app.url').'/'.base64_encode($spread->number) }}"  autocomplete="off" class="layui-input" lay-verify="required">
            </div>
        </div>

        <div class="layui-form-item">
            <label for="longtimes" class="layui-form-label">
                选择产品
            </label>
            <div class="layui-input-block">
                <select name="pid" lay-search lay-filter="product" lay-verify="required">
                    <option value="">选择产品</option>
                    @foreach ($products as $product)
                        @if ($product->id == $spread->pid)
                            <option value="{{ $product->id }}" selected>{{ $product->name }}</option>
                        @else
                            <option value="{{ $product->id }}">{{ $product->name }}</option>
                        @endif
                    @endforeach
                </select>
            </div>
        </div>

        <div class="layui-form-item" id="pages-item">
            <label for="longtimes" class="layui-form-label">
                选择页面
            </label>
            <div class="layui-input-block" id="pages">
                @foreach($pages as $page)
                    @if (in_array($page->id,$current))
                            <input type="checkbox" name="pages[]" checked value="{{ $page->id }}" title="{{ $page->name }}">
                        @else
                            <input type="checkbox" name="pages[]" value="{{ $page->id }}" title="{{ $page->name }}">
                        @endif
                    @endforeach
            </div>
        </div>

        <div class="layui-form-item">
            <label for="status" class="layui-form-label">
                流量控制
            </label>
            <div class="layui-input-block">
                <input type="text" id="name" name="change"
                       autocomplete="off" value="{{ $spread->change }}" class="layui-input" lay-verify="required">
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

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        //监听提交
        form.on('submit(add)', function(data){
            console.log(data);
            data.field.id = "{{ $spread->id }}";
            //发异步，把数据提交给php
            $.ajax({
                url: "{{ route('spreads.update',['id' => $spread->id]) }}",
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
                        let field = ['name','pages','pid'];
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

        form.on('select(product)', function(data){
            console.log(data.elem); //得到select原始DOM对象
            console.log(data.value); //得到被选中的值
            console.log(data.othis); //得到美化后的DOM对象

            $.ajax({
                url: "{{ route('admin.productPages.product') }}",
                type: 'get',
                data: {pid:data.value},
                dataType: 'json',
                success: function (res) {
                    if (res.status == 200) {
                        let str = '';
                        $.each(res.data,function(i,c){
                            str += '<input type="checkbox" name="pages[]" value="'+c.id+'" title="'+c.name+'">'
                        });
                        $('#pages-item').show();
                        $('#pages').html(str);
                        form.render();
                    } else {
                        $('#pages-item').hide();
                        layer.open({
                            title: '提示',
                            content: res.msg,
                        });
                    }
                }
            })
        });
    });
</script>
</body>
</html>