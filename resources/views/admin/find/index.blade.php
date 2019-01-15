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
            <div class="layui-card">
                    <div class="layui-card-header">
                    </div>
                    <div class="layui-card-body">
                        <div class="layui-form-item">
                            <label class="layui-form-label">推荐</label>
                            <div class="layui-input-block">
                                <input type="text" name="recommend" value="{{ $content['recommend'] }}" required  lay-verify="required" placeholder="请输入标题" autocomplete="off" class="layui-input">
                            </div>
                        </div>

                        <div class="layui-form-item">
                            <label class="layui-form-label">客服</label>
                            <div class="layui-input-block">
                                <input type="text" name="server" value="{{ $content['server'] }}" required  lay-verify="required" placeholder="请输入标题" autocomplete="off" class="layui-input">
                            </div>
                        </div>

                        <div class="layui-form-item">
                            <label class="layui-form-label">注意</label>
                            <div class="layui-input-block">
                                <textarea name="notice" style="display: none" id="notice" cols="30" rows="10">{{ $content['notice'] }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
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
    layui.use(['layedit','form'], function(){
        var layedit = layui.layedit;
        var form = layui.form;
        var notice = layedit.build('notice',{
            tool: ['left', 'center', 'right', '|', 'face']
        }); //建立编辑器

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });


        //监听提交
        form.on('submit(add)', function(data){
            console.log(data);
            data.field.notice = layedit.getContent(notice);
            //发异步，把数据提交给php
            $.ajax({
                url: "{{ route('admin.find.store') }}",
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
    });
</script>
</body>
</html>