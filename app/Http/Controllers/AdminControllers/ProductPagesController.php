<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Requests\ProductPageRequest;
use App\Models\Product;
use Auth;
use App\Models\ProductPage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductPagesController extends Controller
{
    public function index()
    {
        return view('admin.productPages.index');
    }

    public function data(ProductPage $page,Request $request)
    {
        $offset = ($request->get('page')-1)*$request->get('limit');
        $count = $page->count('id');
        $data = $page->offset($offset)->limit($request->get('limit'))->orderByDesc('id')->get();
        foreach ($data as $k => $v) {
            $data[$k]['productPages'] = $v->product->name;
            $data[$k]['del'] = Auth::guard('admin')->user()->can('删除页面');
            $data[$k]['edit'] = Auth::guard('admin')->user()->can('修改页面');
        }

        return [
            'code'=> 0,
            'msg' => '',
            'count' => $count,
            'data' => $data
        ];
    }

    public function create(Product $product)
    {
        $products = $product->get();
        return view('admin.productPages.create',['products' => $products]);
    }

    public function store(ProductPage $page,ProductPageRequest $request)
    {

        $page->pages = $this->addHttp($request->pages);
        $page->name = $request->name;
        $page->pid = $request->pid;
        $page->sort = $request->sort;

        if ($page->save()) {
            return ['status' => 200,'msg' => '添加成功'];
        } else {
            return ['status' => 402,'msg' => '添加失败'];
        }
    }

    public function edit(ProductPage $productPage,Product $product)
    {
        $products = $product->get();
        return view('admin.productPages.edit',[
            'page' => $productPage,
            'products' => $products,
        ]);
    }

    public function update(ProductPage $productPage,ProductPageRequest $request)
    {
        $productPage->name = $request->name;
        $productPage->pid = $request->pid;
        $productPage->sort = $request->sort;
        $productPage->pages = $this->addHttp($request->pages);


        if ($productPage->save()) {
            return ['status' => 200,'msg' => '修改成功'];
        } else {
            return ['status' => 402,'msg' => '修改失败'];
        }
    }

    public function destroy(ProductPage $productPage)
    {
        if ($productPage->delete()) {
            return ['status' => 200,'msg' => '删除成功'];
        } else {
            return ['status' => 422,'msg' => '删除失败'];
        }
    }

    protected function addHttp($value)
    {
        if (strpos($value,'http://') === false) {
            $value = 'http://'.$value;
        }
        return $value;
    }

    public function search(ProductPage $productPage,Request $request)
    {
        $offset = ($request->get('page')-1)*$request->get('limit');
        $where = $this->filterItem($request);
        $data = $productPage->where($where)->offset($offset)->limit($request->get('limit'))->get();
        $count = $productPage->where($where)->count('id');
        foreach ($data as $k => $v) {
            $data[$k]['del'] = Auth::guard('admin')->user()->can('删除页面');
            $data[$k]['edit'] = Auth::guard('admin')->user()->can('修改页面');
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
        ];
        foreach ($item as $k => $v) {
            if ($request->$k) {
                $where[] = $v;
            }
        }

        if ($request->column) {
            $where[] = [$request->column,'like','%'.$request->column_value.'%'];
        }

        return $where;
    }

    public function getProductPages(ProductPage $productPage,Request $request)
    {
        $pid = $request->pid;
        // 得到该产品的页面
        $pages = $productPage->where('pid',$pid)->get();
        //dd(count($pages) == 0);
        if (!count($pages) == 0) {
            return ['status' => 200,'data'=> $pages];
        } else {
            return ['status' => 402,'msg' => '没有该产品的页面数据，请去产品页面添加。'];
        }
    }
}

