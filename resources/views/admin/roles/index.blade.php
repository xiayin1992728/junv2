@include('admin.layouts._meta')
<meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
<div class="x-nav">
    <a class="layui-btn layui-btn-small" style="line-height:1.6em;margin-top:3px;float:right" href="javascript:location.replace(location.href);" title="刷新">
        <i class="layui-icon" style="line-height:30px">&#xe669;</i></a>
</div>
<div class="x-body">
    <table id="roles" lay-filter="roles" lay-data="{id: 'roles'}"></table>
</div>
@include('admin.layouts._footer')
<script type="text/html" id="barDemo">
    @{{# if(d.edit) { }}
    <a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a>
    @{{# } }}

    @{{# if(d.del) { }}
    <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
    @{{# } }}
</script>
<script>
    layui.use(['table','form'], function(){
        var table = layui.table;
        var form = layui.form;

        //第一个实例
        table.render({
            elem: '#roles',
            height: 500,
            url: "{{ route('admin.roles.data') }}", //数据接口
            page: {limits:[10,20,50,100]}, //开启分页
            cols: [[ //表头
                {type: 'checkbox', fixed: 'left'},
                {field: 'id', title: 'ID', width:80, align:'center', sort: true, fixed: 'left'},
                {field: 'name', title: '名称',align:'center'},
                {field: 'permission', title: '拥有权限',align:'center'},
                {field: 'created_at', title: '创建时间',sort:true,align:'center'},
                {field: 'updated_at', title: '修改时间',sort:true,align:'center'},
                    @if(auth()->guard('admin')->user()->can('修改角色') || auth()->guard('admin')->user()->can('删除用户'))
                {fixed: 'right', width: 165, title: '操作', align:'center', toolbar: '#barDemo'}
                @endif
            ]],
            @if(auth()->guard('admin')->user()->can('添加角色'))
            toolbar:'<div><button class="layui-btn" onclick="x_admin_show(\'添加角色\',\'{{ route('roles.create') }}\',\'1000\',\'400\')"><i class="layui-icon"></i>添加</button></div>',
            @else
            toolbar:'true',
            @endif
            defaultToolbar:['filter', 'print','exports'],
        });

        //监听行工具事件
        table.on('tool(roles)', function(obj){ //注：tool 是工具条事件名，test 是 table 原始容器的属性 lay-filter="对应的值"
            var data = obj.data //获得当前行数据
                ,layEvent = obj.event; //获得 lay-event 对应的值
            console.log(obj.data);
            if(layEvent === 'detail'){

            } else if(layEvent === 'del'){
                layer.confirm('确认删除数据吗?', function(index){
                    layer.close(index);
                    //向服务端发送删除指令
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url:"{{ env('APP_URL') }}"+'/admin/roles/'+obj.data.id,
                        type:'delete',
                        dataType:'json',
                        success:function (res) {
                            if (res.status == 200) {
                                obj.del(); //删除对应行（tr）的DOM结构
                                layer.msg(res.msg,{icon:6});
                            } else {
                                layer.msg(res.msg,{icon:5});
                            }
                        },
                        error:function (res) {

                        }
                    })
                });
            } else if(layEvent === 'edit'){
                x_admin_show('角色编辑','{{ env('APP_URL') }}'+'/admin/roles/'+obj.data.id+'/edit',1000,400);
            }
        });
    });
</script>
</body>
</html>