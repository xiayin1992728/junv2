@include('admin.layouts._meta')
<meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
<div class="x-nav">
    <a class="layui-btn layui-btn-small" style="line-height:1.6em;margin-top:3px;float:right"
       href="javascript:location.replace(location.href);" title="刷新">
        <i class="layui-icon" style="line-height:30px">&#xe669;</i></a>
</div>
<div class="x-body">
    <div class="layui-row">
        <form class="layui-form layui-col-md12 x-so">
            <input class="layui-input" placeholder="开始时间" autocomplete="off" name="start" id="start">
            <input class="layui-input" placeholder="截止时间" autocomplete="off" name="end" id="end">
            <div class="layui-input-inline">
                <select name="column">
                    <option value="name" selected>渠道名称</option>
                </select>
            </div>
            <input type="text" name="column_value" placeholder="请输入" autocomplete="off" class="layui-input">
            <button class="layui-btn" lay-submit="" lay-filter="search"><i class="layui-icon">&#xe615;</i></button>
        </form>
    </div>
    <table id="channels" lay-filter="channels" lay-data="{id: 'channels'}"></table>
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
    layui.use(['table', 'laydate', 'form'], function () {
        var table = layui.table;
        var laydate = layui.laydate;
        var form = layui.form;
        //执行一个laydate实例
        laydate.render({
            elem: '#start', //指定元素
            type: 'datetime'
        });

        //执行一个laydate实例
        laydate.render({
            elem: '#end', //指定元素
            type: 'datetime'
        });

        //第一个实例
        table.render({
            elem: '#channels',
            height: 'full-200',
            url: "{{ route('admin.channels.data') }}", //数据接口
            page: {limits: [10, 20, 50, 100, 400]}, //开启分页
            cols: [[ //表头
                {type: 'checkbox', fixed: 'left'},
                {
                    field: 'id',
                    title: 'ID',
                    width: 50,
                    align: 'center',
                    sort: true,
                    fixed: 'left',
                },
                {field: 'name', title: '渠道名称', align: 'center'},
                {field: 'company', title: '公司名称', align: 'center'},
                {field: 'types', title: '结算方式', align: 'center'},
                {field: 'adminChannel', title: '所属推广者', align: 'center'},
                {field: 'created_at', title: '创建时间', sort: true, align: 'center', width: 200},
                {field: 'updated_at', title: '修改时间', sort: true, align: 'center', width: 200},
                    @if(auth()->guard('admin')->user()->can('修改渠道') || auth()->guard('admin')->user()->can('删除渠道'))
                {
                    fixed: 'right', width: 165, title: '操作', align: 'center', toolbar: '#barDemo'
                }
                @endif
            ]],
            @if(auth()->guard('admin')->user()->can('添加渠道'))
            toolbar: '<div><button class="layui-btn" onclick="x_admin_show(\'添加渠道\',\'{{ route('channels.create') }}\',\'400\',\'400\')"><i class="layui-icon"></i>添加</button></div>',
            @else
            toolbar: 'true',
            @endif
            defaultToolbar: ['filter', 'print', 'exports'],
        });


        //监听行工具事件
        table.on('tool(channels)', function (obj) { //注：tool 是工具条事件名，test 是 table 原始容器的属性 lay-filter="对应的值"
            var data = obj.data //获得当前行数据
                , layEvent = obj.event; //获得 lay-event 对应的值
            if (layEvent === 'status') {
            } else if (layEvent === 'del') {
                layer.confirm('确认删除数据吗?', function (index) {
                    layer.close(index);
                    //向服务端发送删除指令
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: "{{ config('app.url') }}" + '/admin/channels/' + obj.data.id,
                        type: 'delete',
                        dataType: 'json',
                        success: function (res) {
                            if (res.status == 200) {
                                obj.del(); //删除对应行（tr）的DOM结构
                                layer.msg(res.msg, {icon: 6});
                            } else {
                                layer.msg(res.msg, {icon: 5});
                            }
                        },
                        error: function (res) {

                        }
                    })
                });
            } else if (layEvent === 'edit') {
                x_admin_show('渠道编辑', '{{ config('app.url') }}' + '/admin/channels/' + obj.data.id + '/edit', 400, 400);
            }
        });

        // 搜索
        form.on('submit(search)', function (data) {
            console.log(data.field) //当前容器的全部表单字段，名值对形式：{name: value}
            table.reload('channels', {
                url: "{{ route('admin.channels.search') }}",
                where: data.field //设定异步数据接口的额外参数
            });
            return false; //阻止表单跳转。如果需要表单跳转，去掉这段即可。
        });
    });
</script>
</body>
</html>