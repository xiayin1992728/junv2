@include('admin.layouts._meta')
<meta name="csrf-token" content="{{ csrf_token() }}">
<style>
    .imgs {
        height: auto !important;
        white-space: normal;
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
    <div class="layui-row">
        <form class="layui-form layui-col-md12 x-so">
            <input class="layui-input" placeholder="开始时间" autocomplete="off" name="start" id="start">
            <input class="layui-input" placeholder="截止时间" autocomplete="off" name="end" id="end">
            <div class="layui-input-inline">
                <select name="column">
                    <option value="">选择搜条件</option>
                    <option value="name">产品名</option>
                    <option value="types">产品类型</option>
                </select>
            </div>
            <input type="text" name="column_value" placeholder="请输入" autocomplete="off" class="layui-input">
            <button class="layui-btn" lay-submit="" lay-filter="search"><i class="layui-icon">&#xe615;</i></button>
        </form>
    </div>
    <table id="products" lay-filter="products" lay-data="{id: 'products'}"></table>
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
<script type="text/html" id="imgTpl">
    <img style="width: 50px;height: 50px" src="@{{ d.logo }}">
</script>
<script type="text/html" id="status">
    @{{# if( d.status ) { }}
    <a class="layui-btn layui-btn-normal layui-btn-sm" lay-event="status">已上架</a>
    @{{# }else { }}
    <a class="layui-btn layui-btn-danger layui-btn-sm" lay-event="status">已下架</a>
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
            elem: '#products',
            height: 'full-200',
            url: "{{ route('admin.products.data') }}", //数据接口
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
                    style: 'height: 61px'
                },
                {field: 'name', title: '产品名称', align: 'center', width: 180},
                {field: 'logo', title: 'logo', align: 'center', templet: '#imgTpl', width: 65},
                {
                    field: 'maxs',
                    title: '最大额度',
                    align: 'center',
                    width: 100,
                    templet: '<span><strong>@{{ d.maxs }}元</strong></span>'
                },
                {field: 'tag', title: '简介', align: 'center', width: 300},
                {
                    field: 'longtimes',
                    title: '借款期限',
                    align: 'center',
                    width: 90,
                    templet: '<span><strong>@{{ d.longtimes }}</strong>天</span>'
                },
                {field: 'link', title: '链接', align: 'center', width: 500},
                {field: 'saleman', title: '业务员', align: 'center', width: 100},
                @if(auth()->guard('admin')->user()->can('产品上下架'))
                    {field: 'statusText', title: '状态', align: 'center', width: 90, templet: '#status'},
                @else
                    {field: 'statusText', title: '状态', align: 'center', width: 90, templet: '<span>@{{ d.statusText }}<span>'},
                @endif
                {field: 'types', title: '类型', align: 'center', width: 100},
                {field: 'created_at', title: '创建时间', sort: true, align: 'center', width: 200},
                {field: 'updated_at', title: '修改时间', sort: true, align: 'center', width: 200},
                    @if(auth()->guard('admin')->user()->can('修改产品') || auth()->guard('admin')->user()->can('删除产品'))
                {
                    fixed: 'right', width: 165, title: '操作', align: 'center', style: 'height:61px', toolbar: '#barDemo'
                }
                @endif
            ]],
            @if(auth()->guard('admin')->user()->can('添加产品'))
            toolbar: '<div><button class="layui-btn" onclick="x_admin_show(\'添加产品\',\'{{ route('products.create') }}\',\'1000\',\'400\')"><i class="layui-icon"></i>添加</button></div>',
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


        //监听行工具事件
        table.on('tool(products)', function (obj) { //注：tool 是工具条事件名，test 是 table 原始容器的属性 lay-filter="对应的值"
            var data = obj.data //获得当前行数据
                , layEvent = obj.event; //获得 lay-event 对应的值
            if (layEvent === 'status') {
                console.log(obj.data.status);
                let title = obj.data.status ? '下架' : '上架';
                layer.confirm('确认'+title+'该产品吗?', function (index) {
                    layer.close(index);
                    //向服务端发送删除指令
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: "{{ config('app.url') }}" + '/admin/products/status/' + obj.data.id,
                        type: 'put',
                        dataType: 'json',
                        success: function (res) {
                            if (res.status == 200) {
                                //.replace(location.href);
                                if (obj.data.status) {
                                    $(obj.tr[0]).find("td[data-field='status'] .layui-table-cell").html('<a class="layui-btn layui-btn-danger layui-btn-sm" lay-event="status">已下架</a>');
                                    obj.update({status:0,statusText:'已下架'})
                                } else {
                                    $(obj.tr[0]).find("td[data-field='status'] .layui-table-cell").html('<a class="layui-btn layui-btn-normal layui-btn-sm" lay-event="status">已上架</a>');
                                    obj.update({status:1,statusText:'已上架'});
                                }
                                console.log(obj.data);
                                layer.msg(res.msg, {icon: 6});
                            } else {
                                layer.msg(res.msg, {icon: 5});
                            }
                        },
                        error: function (res) {

                        }
                    })
                });

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
                        url: "{{ env('APP_URL') }}" + '/admin/products/' + obj.data.id,
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
                x_admin_show('产品编辑', '{{ env('APP_URL') }}' + '/admin/products/' + obj.data.id + '/edit', 1000, 400);
            }
        });

        // 搜索
        form.on('submit(search)', function (data) {
            console.log(data.field) //当前容器的全部表单字段，名值对形式：{name: value}
            table.reload('products', {
                url: "{{ route('admin.products.search') }}",
                where: data.field //设定异步数据接口的额外参数
            });
            return false; //阻止表单跳转。如果需要表单跳转，去掉这段即可。
        });
    });
</script>
</body>
</html>