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
                <select name="uid" lay-search>
                    <option value="">选择推广员</option>
                   @foreach($admins as $admin)
                        <option value="{{ $admin->id }}">{{ $admin->name }}</option>
                       @endforeach
                </select>
            </div>
            <button class="layui-btn" lay-submit="" lay-filter="search"><i class="layui-icon">&#xe615;</i></button>
        </form>
    </div>
    <table id="spreads" lay-filter="spreads" lay-data="{id: 'spreads'}"></table>
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

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        //第一个实例
        table.render({
            elem: '#spreads',
            height: 'full-200',
            url: "{{ route('admin.spreads.data') }}", //数据接口
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
                {field: 'number', title: '流水号', align: 'center', width: 180},
                {field: 'link', title: '推广链接', align: 'center', width: 500,height:60},
                {field: 'productName', title: '所属产品', align: 'center', width: 200},
                {field: 'adminName', title: '所属推广者', align: 'center', width: 200},
                {field: 'pagesText', title: '页面控制', align: 'center', width: 200},
                {field: 'change', title: '流量控制', align: 'center', width: 200,edit: 'text'},
                {field: 'created_at', title: '创建时间', sort: true, align: 'center', width: 200},
                {field: 'updated_at', title: '修改时间', sort: true, align: 'center', width: 200},
                    @if(auth()->guard('admin')->user()->can('修改推广') || auth()->guard('admin')->user()->can('删除推广'))
                {
                    fixed: 'right', width: 165, height: 60, title: '操作', align: 'center', toolbar: '#barDemo'
                }
                @endif
            ]],
            @if(auth()->guard('admin')->user()->can('添加推广'))
            toolbar: '<div><button class="layui-btn" onclick="x_admin_show(\'添加推广\',\'{{ route('spreads.create') }}\',\'700\',\'400\')"><i class="layui-icon"></i>添加</button></div>',
            @else
            toolbar: 'true',
            @endif
            defaultToolbar: ['filter', 'print', 'exports'],
            done: function () {
                $("td[data-field='logo']").each(function () {
                    $(this).find(".layui-table-cell").removeClass('layui-table-cell');
                });

                $("td[data-field='link']").each(function () {
                    $(this).find(".layui-table-cell").removeClass('layui-table-cell');
                });
            }
        });

        //监听单元格编辑
        table.on('edit(spreads)', function(obj){
            var value = obj.value //得到修改后的值
                ,data = obj.data //得到所在行所有键值
                ,field = obj.field; //得到字段

            console.log(obj.data);
            $.ajax({
                url: "{{ config('app.url') }}"+'/admin/spreads/'+obj.data.id,
                type: 'put',
                data: obj.data,
                dataType: 'json',
                success: function (res) {
                    console.log(res);
                }
            })
        });

        //监听行工具事件
        table.on('tool(spreads)', function (obj) { //注：tool 是工具条事件名，test 是 table 原始容器的属性 lay-filter="对应的值"
            var data = obj.data //获得当前行数据
                , layEvent = obj.event; //获得 lay-event 对应的值
            if (layEvent === 'status') {
            } else if (layEvent === 'del') {
                layer.confirm('确认删除数据吗?', function (index) {
                    layer.close(index);
                    //向服务端发送删除指令
                    $.ajax({
                        url: "{{ config('app.url') }}" + '/admin/spreads/' + obj.data.id,
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
                x_admin_show('页面编辑', '{{ config('app.url') }}' + '/admin/spreads/' + obj.data.id + '/edit', 600, 400);
            }
        });

        // 搜索
        form.on('submit(search)', function (data) {
            console.log(data.field); //当前容器的全部表单字段，名值对形式：{name: value}
            table.reload('spreads', {
                url: "{{ route('admin.spreads.search') }}",
                where: data.field, //设定异步数据接口的额外参数
                //page: false
            });
            return false; //阻止表单跳转。如果需要表单跳转，去掉这段即可。
        });
    });
</script>
</body>
</html>