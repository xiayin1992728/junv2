<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Requests\ProductRequest;
use App\Models\Product;
use Auth;
use App\Handlers\ImageUploadHandler;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductsController extends Controller
{
    public function index()
    {
        return view('admin.products.index');
    }

    public function data(Product $product,Request $request)
    {
        $offset = ($request->get('page')-1)*$request->get('limit');
        $count = $product->count('id');
        $data = $product->offset($offset)->limit($request->get('limit'))->orderByDesc('id')->get();
        foreach ($data as $k => $v) {
            $data[$k]['statusCan'] = Auth::guard('admin')->user()->can('产品上下架');
            $data[$k]['status'] = $v->status;
            $data[$k]['del'] = Auth::guard('admin')->user()->can('删除产品');
            $data[$k]['edit'] = Auth::guard('admin')->user()->can('修改产品');
        }

        return [
            'code'=> 0,
            'msg' => '',
            'count' => $count,
            'data' => $data
        ];
    }

    public function create()
    {

        return view('admin.products.create');
    }

    public function store(Product $product,ProductRequest $request)
    {
       $product->name = $request->name;
       $product->logo = $request->logo;
       $product->maxs = $request->maxs;
       $product->tag = $request->tag;
       $product->longtimes = $request->longtimes;
       $product->link = $this->addHttp($request->link);
       $product->saleman = $request->saleman;
       $product->types = $request->types;
       $product->status = $request->status;

        if ($product->save()) {
            return ['status' => 200,'msg' => '添加成功'];
        } else {
            return ['status' => 402,'msg' => '添加失败'];
        }
    }

    public function edit(Product $product)
    {
        return view('admin.products.edit',[
            'product' => $product
        ]);
    }

    public function update(Product $product,ProductRequest $request)
    {
        $product->name = $request->name;
        $product->logo = $request->logo;
        $product->maxs = $request->maxs;
        $product->tag = $request->tag;
        $product->longtimes = $request->longtimes;
        $product->link = $this->addHttp($request->link);
        $product->saleman = $request->saleman;
        $product->types = $request->types;
        $product->status = $request->status;

        if ($product->save()) {
            return ['status' => 200,'msg' => '修改成功'];
        } else {
            return ['status' => 402,'msg' => '修改失败'];
        }
    }

    public function destroy(Product $product)
    {
        if ($product->delete()) {
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

    public function search(Product $product,Request $request)
    {
        $offset = ($request->get('page')-1)*$request->get('limit');
        $count = $product->count('id');
        $where = $this->filterItem($request);
        $data = $product->where($where)->offset($offset)->limit($request->get('limit'))->get();
        foreach ($data as $k => $v) {
            $data[$k]['del'] = Auth::guard('admin')->user()->can('删除产品');
            $data[$k]['edit'] = Auth::guard('admin')->user()->can('修改产品');
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
            $where[] = [$request->column,'like',$request->column_value.'%'];
        }

        return $where;
    }

    public function status(Product $product,$id)
    {
        $product = $product->find($id);

        if ($product->status) {
            $product->status = 0;
        } else {
            $product->status = 1;
        }

        if ($product->save()) {
            return ['status' => 200, 'msg' => '修改成功'];
        } else {
            return ['status' => 402, 'msg' => '修改失败'];
        }
    }

    public function uploads(ImageUploadHandler $upload,Request $request)
    {

       $result =  $upload->save($request->file,'admin/logo');

       if ($result) {
            return ['status' => 200,'path' => $result['path']];
       } else {
           return ['status' => 422,'msg' => '上传失败'];
       }
    }
}
