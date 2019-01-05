@include('admin.layouts._meta')
</head>
<body>
<!-- 顶部开始 -->
@include('admin.layouts._header')
<!-- 顶部结束 -->
<!-- 中部开始 -->
<!-- 左侧菜单开始 -->

@include('admin.layouts._menu')
<!-- <div class="x-slide_left"></div> -->
<!-- 左侧菜单结束 -->
<!-- 右侧主体开始 -->
<div class="page-content">
    <div class="layui-tab tab" lay-filter="xbs_tab" lay-allowclose="false">
        <ul class="layui-tab-title">
            <li class="home"><i class="layui-icon">&#xe68e;</i>我的桌面</li>
        </ul>
        <div class="layui-tab-content">
            <div class="layui-tab-item layui-show">
                <iframe src='{{ route('welcome') }}' frameborder="0" scrolling="yes" class="x-iframe"></iframe>
            </div>
        </div>
    </div>
</div>
<div class="page-content-bg"></div>
<!-- 右侧主体结束 -->
<!-- 中部结束 -->
<!-- 底部开始 -->
<div class="footer">
    <div class="copyright">Copyright ©2017</div>
</div>
<!-- 底部结束 -->
</body>
@include('admin.layouts._footer')
</html>