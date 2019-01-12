@include('admin.layouts._meta')
</head>
<body>
<div class="x-body layui-anim layui-anim-up">
    <blockquote class="layui-elem-quote">欢迎：
        <span class="x-red">{{ Auth::guard('admin')->user()->name }}</span>！当前时间:{{ date('Y-m-d H:i:s',time()) }}</blockquote>
    <fieldset class="layui-elem-field">
        <legend>系统信息</legend>
        <div class="layui-field-box">
            <table class="layui-table">
                <tbody>
                <tr>
                    <th>xxx版本</th>
                    <td>1.0.180420</td></tr>
                <tr>
                    <th>服务器地址</th>
                    <td>x.xuebingsi.com</td></tr>
                <tr>
                    <th>操作系统</th>
                    <td>WINNT</td></tr>
                <tr>
                    <th>运行环境</th>
                    <td>Apache/2.4.23 (Win32) OpenSSL/1.0.2j mod_fcgid/2.3.9</td></tr>
                <tr>
                    <th>PHP版本</th>
                    <td>5.6.27</td></tr>
                <tr>
                    <th>PHP运行方式</th>
                    <td>cgi-fcgi</td></tr>
                <tr>
                    <th>MYSQL版本</th>
                    <td>5.5.53</td></tr>
                <tr>
                    <th>ThinkPHP</th>
                    <td>5.0.18</td></tr>
                <tr>
                    <th>上传附件限制</th>
                    <td>2M</td></tr>
                <tr>
                    <th>执行时间限制</th>
                    <td>30s</td></tr>
                <tr>
                    <th>剩余空间</th>
                    <td>86015.2M</td></tr>
                </tbody>
            </table>
        </div>
    </fieldset>
</div>
</body>
</html>