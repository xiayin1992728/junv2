<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Spread;
use Auth;

class CheckLink
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $sid = Auth::guard('web')->user()->sid;

        $idcard = Auth::guard('web')->user()->idcard;

        if ($sid) {
            $spread = new Spread();
            // 得到当前访问的 URL
            $url = url()->current();
            // 查询出推广链接
            $spread = $spread->where('id', $sid)->first();
            // 得到页面执行顺序
            $pages = $spread->product->productPage()->orderBy('sort','asc')->pluck('pages')->toArray();

            // 得到拥有的权限
            $auth = $spread->productPage()->pluck('pages')->toArray();

            // 得到当前页面在执行顺序中的 位置
            $mark = array_search($url,$pages);
            // 遍历执行顺序 对比 每个页面是否有权限
            foreach ($pages as $k => $v) {
                if ($k == $mark && in_array($url,$auth)) {
                    if ($idcard && $url == config('app.url').'/verify') {
                        return redirect($pages[$k+1]);
                    }
                    break;
                } else if($k > (count($auth)-1)) {
                    return redirect($pages[count($auth)-1]);
                }
            }
        }

        return $next($request);
    }
}
