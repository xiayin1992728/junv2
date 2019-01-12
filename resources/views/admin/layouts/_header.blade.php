<div class="container">
    <div class="logo"><a href="./index.html">钱富贵</a></div>
    <div class="left_open">
        <i title="展开左侧栏" class="iconfont">&#xe66b;</i>
    </div>
    <ul class="layui-nav right" lay-filter="">
        <li class="layui-nav-item">
            <a href="javascript:;">{{ Auth::user()->name }}</a>
            <dl class="layui-nav-child"> <!-- 二级菜单 -->
                <dd><a onclick="document.getElementById('subform').submit();">退出
                        <form action="{{ route('admin.logout') }}" id="subform" method="post">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                        </form>
                    </a></dd>
            </dl>
        </li>
    </ul>

</div>