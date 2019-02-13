<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Requests\SpreadRequest;
use App\Models\Admin;
use App\Models\Channel;
use Auth;
use App\Models\Product;
use App\Models\Spread;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SpreadsController extends Controller
{
    public function index(Admin $admin)
    {
        $admins = $admin->role('推广员')->get();
        return view('admin.spreads.index',['admins' => $admins]);
    }

    public function data(Spread $spread,Request $request)
    {
        $offset = ($request->get('page')-1)*$request->get('limit');
        $count = $spread->count('id');
        $data = $spread->offset($offset)->limit($request->get('limit'))->orderByDesc('id')->get();
        foreach ($data as $k => $v) {
            $data[$k]['productName'] = $v->product->name;
            $data[$k]['adminName'] = $v->admin->name;
            $data[$k]['link'] = config('app.url').'/'.base64_encode($v->number);
            $data[$k]['pagesText'] = $v->productPage->pluck('name');
            $data[$k]['pages'] = $v->productPage->pluck('id');
            $data[$k]['del'] = Auth::guard('admin')->user()->can('删除推广');
            $data[$k]['edit'] = Auth::guard('admin')->user()->can('修改推广');
        }

        return [
            'code'=> 0,
            'msg' => '',
            'count' => $count,
            'data' => $data
        ];
    }

    public function create(Product $product,Admin $admin)
    {
        $products = $product->get();
        $admins = $admin::role('推广员')->get();
        return view('admin.spreads.create', [
            'admins' => $admins,
            'products' => $products,
        ]);
    }

    public function store(Spread $spread,SpreadRequest $request)
    {
        $number = date('YmdHis',time()).random_int(99999,100000);
        $spread->uid = $request->uid;
        $spread->pid = $request->pid;
        $spread->number = $number;
        $spread->change = $request->change;
        if ($spread->save()) {
            $spread->productPage()->attach($request->pages);
            return ['status' => 200,'msg' => '添加成功'];
        } else {
            return ['status' => 402,'msg' => '添加失败'];
        }
    }

    public function edit(Admin $admin,Product $product,Spread $spread)
    {
        $products = $product->get();
        $admins = $admin->role('推广员')->get();
        return view('admin.spreads.edit',[
            'products' => $products,
            'admins' => $admins,
            'spread' => $spread,
            'pages' => $spread->product->productPage,
            'current' => $spread->productPage->pluck('id')->toArray(),
        ]);
    }

    public function update(Spread $spread,SpreadRequest $request)
    {
        $spread->uid = $request->uid;
        $spread->pid = $request->pid;
        $spread->change = $request->change;

        if ($spread->save()) {
            $spread->productPage()->sync($request->pages);
            return ['status' => 200,'msg' => '修改成功'];
        } else {
            return ['status' => 402,'msg' => '修改失败'];
        }
    }

    public function destroy(Spread $spread)
    {
        if ($spread->delete()) {
            return ['status' => 200,'msg' => '删除成功'];
        } else {
            return ['status' => 422,'msg' => '删除失败'];
        }
    }

    public function search(Spread $spread,Request $request)
    {
        $offset = ($request->get('page')-1)*$request->get('limit');

        $where = $this->filterItem($request);
        $data = $spread->where($where)->offset($offset)->limit($request->get('limit'))->get();
        $count = $spread->where($where)->count('id');
        foreach ($data as $k => $v) {
            $data[$k]['productName'] = $v->product->name;
            $data[$k]['adminName'] = $v->admin->name;
            $data[$k]['link'] = config('app.url').'/'.base64_encode($v->number);
            $data[$k]['pagesText'] = $v->productPage->pluck('name');
            $data[$k]['pages'] = $v->productPage->pluck('id');
            $data[$k]['del'] = Auth::guard('admin')->user()->can('删除推广');
            $data[$k]['edit'] = Auth::guard('admin')->user()->can('修改推广');
        }

        return [
            'code'=> 0,
            'msg' => '',
            'count' => $count,
            'data' => $data
        ];
    }

    protected function filterItem($request,$where = [])
    {
        $item = [
            'start' => ['created_at','>',$request->start],
            'end' => ['created_at','<',$request->end],
            'uid' => ['uid',$request->uid],
        ];
        foreach ($item as $k => $v) {
            if ($request->$k) {
                $where[] = $v;
            }
        }

        return $where;
    }


    public function salesmanSpreads(Spread $spread,$uid)
    {
            dd($uid);
    }
}
