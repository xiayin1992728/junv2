<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Requests\PermissionsRequest;
use Illuminate\Http\Request;
use Auth;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;

class PermissionsController extends Controller
{
    public function index()
    {
        return view('admin.permissions.index');
    }

    public function data(Permission $permission,Request $request)
    {
        $offset = ($request->get('page')-1)*$request->get('limit');
        $count = $permission->count('id');
        $data = $permission->offset($offset)->limit($request->get('limit'))->get();
        foreach ($data as $k => $v) {
            $data[$k]['del'] = Auth::guard('admin')->user()->can('删除权限');
            $data[$k]['edit'] = Auth::guard('admin')->user()->can('修改权限');
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
        return view('admin.permissions.create');
    }

    public function store(Permission $permission,PermissionsRequest $request)
    {
        $permission->name = $request->name;

        if ($permission->save()) {
            return ['status' => 200,'msg' => '添加成功'];
        } else {
            return ['status' => 402,'msg' => '添加失败'];
        }
    }

    public function edit(Permission $permission)
    {
        return view('admin.permissions.edit',['permission' => $permission]);
    }

    public function update(Permission $permission,PermissionsRequest $request)
    {
        $permission->name = $request->name;

        if ($permission->save()) {
            return ['status' => 200,'msg' => '修改成功'];
        } else {
            return ['status' => 402,'msg' => '修改失败'];
        }
    }

    public function destroy(Permission $permission)
    {
        if ($permission->delete()) {
            return ['status' => 200,'msg' => '删除成功'];
        } else {
            return ['status' => 422,'msg' => '删除失败'];
        }
    }
}
