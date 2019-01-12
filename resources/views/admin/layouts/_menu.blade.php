<div class="left-nav">
    <div id="side-nav">
        <ul id="nav">
           @foreach($menus as $menu)
               @can($menu['title'])
                <li>
                <a href="javascript:;">
                    <i class="iconfont">{{ $menu['icon'] }}</i>
                    <cite>{{ $menu['title'] }}</cite>
                    <i class="iconfont nav_right">&#xe602;</i>
                </a>
                <ul class="sub-menu">
                    @foreach($menu['son'] as $v)
                        @can($v['title'])
                            <li>
                        <a _href="{{ route($v['url']) }}">
                            <i class="iconfont">&#xe602;</i>
                            <cite>{{ $v['title'] }}</cite>
                        </a>
                    </li >
                        @endcan
                    @endforeach
                </ul>
            </li>
               @endcan
            @endforeach
        </ul>
    </div>
</div>