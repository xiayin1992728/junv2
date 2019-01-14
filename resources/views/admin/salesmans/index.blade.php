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
            <button class="layui-btn" lay-submit="" lay-filter="search"><i class="layui-icon">&#xe615;</i></button>
        </form>
    </div>
    <div class="layui-row">
        <button class="layui-btn">当天注册总数<span id="register" class="layui-badge layui-bg-gray"></span></button>
        <button class="layui-btn">当天认证总数<span id="verify" class="layui-badge layui-bg-orange"></span></button>
    </div>
    <table id="salesman" lay-filter="salesman" lay-data="{id: 'salesman'}"></table>
</div>
@include('admin.layouts._footer')
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
            elem: '#salesman',
            height: 'full-200',
            url: "{{ route('admin.salesman.data',['id' => $id]) }}", //数据接口
            page: {limits: [10, 20, 50, 100, 400]}, //开启分页
            cols: [[ //表头
                {type: 'checkbox', fixed: 'left'},
                {
                    field: 'id',
                    title: 'ID',
                    width: 100,
                    align: 'center',
                    sort: true,
                    fixed: 'left',
                },
                {field: 'name', title: '用户名称', align: 'center'},
                {field: 'phone', title: '手机号', align: 'center'},
                {field: 'created_at', title: '注册时间', sort: true, align: 'center', width: 200},
            ]],
            toolbar: 'true',
            defaultToolbar: ['filter', 'print'],
            done: function (res) {
                $('#register').text(res.registerNumber);
                $('#verify').text(res.verifyNumber);
            }
        });

        // 搜索
        form.on('submit(search)', function (data) {
            console.log(data.field) //当前容器的全部表单字段，名值对形式：{name: value}
            table.reload('salesman', {
                url: "{{ route('admin.salesman.search',['id' => $id]) }}",
                where: data.field //设定异步数据接口的额外参数
            });
            return false; //阻止表单跳转。如果需要表单跳转，去掉这段即可。
        });
    });
</script>
</body>
</html>