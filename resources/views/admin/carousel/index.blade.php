@include('admin.layouts._meta')
<meta name="csrf-token" content="{{ csrf_token() }}">
<style>
    .imgs{
        position: relative;
        top: -40px;
        left: 300px;
    }
</style>
</head>
<body>
<div class="x-nav">
    <a class="layui-btn layui-btn-small" style="line-height:1.6em;margin-top:3px;float:right"
       href="javascript:location.replace(location.href);" title="刷新">
        <i class="layui-icon" style="line-height:30px">&#xe669;</i></a>
</div>
<div class="x-body">
    <form class="layui-form">
        <div class="carousel">
            @foreach($contents as $k => $content)
            <div class="layui-card">
                <div class="layui-card-header">
                </div>
                <div class="layui-card-body">
                    <div class="layui-form-item">
                        <label for="" class="layui-form-label">上传图片</label>
                        <div class="layui-form-block">
                            <button type="button" class="layui-btn upload">
                                <i class="layui-icon">&#xe67c;</i>上传图片
                            </button>
                        </div>
                        <div class="imgs">
                            <img src="{{ $content['img'] ? config('app.url').'/'.$content['img'] : '' }}" alt="" style="width:50px;height: 50px">
                            <input type="hidden" value="{{ $content['img'] ?: ''}}" name="carousel[{{$k}}][img]">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label for="name" class="layui-form-label">
                            链接地址
                        </label>
                        <div class="layui-input-block">
                            <input type="text" id="name" name="carousel[{{$k}}][url]"
                                   autocomplete="off" value="{{ $content['url'] }}" class="layui-input" lay-verify="required">
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="layui-form-item">
            <label for="L_repass" class="layui-form-label">
            </label>
            <button  class="layui-btn" lay-filter="add" lay-submit="">
                保存
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

        upload.render({
            elem: '.upload',
            url: "{{ route('admin.carousel.upload') }}",
            done: function(res, index, upload){
                //获取当前触发上传的元素，一般用于 elem 绑定 class 的情况，注意：此乃 layui 2.1.0 新增
                var item = this.item;
                console.log(item);
                if (res.status == 200) {
                    $(item).parent('div').next().find('img').attr('src',"{{ config('app.url').'/' }}" +res.path);
                    $(item).parent('div').next().find('input').val(res.path);
                } else {
                    layer.msg(res.msg,{icon:5});
                }
            }
        });

        //监听提交
        form.on('submit(add)', function(data){
            console.log(data);
            //发异步，把数据提交给php
            $.ajax({
                url: "{{ route('admin.carousel.store') }}",
                type: 'post',
                data:data.field,
                dataType: 'json',
                success:function (res) {
                    console.log(res);
                    if (res.status == 200) {
                        layer.msg(res.msg,{icon:6});
                        setTimeout(function(){
                            //关闭当前frame
                            // 刷新页面
                            window.location.href = window.location.href;
                        },500);
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

        // 错误提示
        function makeError(field,data) {
            let len = field.length;
            for (var i=0;i<len;i++) {
                if (data[field[i]] != undefined) {
                    layer.msg(data[field[i]][0],{icon:5});
                    break;
                }
            }
        }

        // 添加轮播图
        // $('#addCarousel').on('click',function(){
        //     $('.carousel').append(str);
        //     console.log(form);
        //     form.render();
        // });

        // $('.carousel').on('click','.carousel-remove',function(){
        //    $(this).parent('div').parent('div').remove();
        // });
    });
</script>
</body>
</html>