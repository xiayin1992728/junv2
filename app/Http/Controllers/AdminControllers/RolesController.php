<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Requests\RolesRequest;
use Illuminate\Http\Request;
use Auth;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesController extends Controller
{
    public function index()
    {
        return view('admin.roles.index');
    }

    public function data(Role $roles,Request $request)
    {
        $offset = ($request->get('page')-1)*$request->get('limit');
        $count = $roles->count('id');
        $data = $roles->offset($offset)->limit($request->get('limit'))->get();
        foreach ($data as $k => $v) {
            $data[$k]['permission'] = $v->permissions->pluck('name');
            $data[$k]['del'] = Auth::guard('admin')->user()->can('删除角色');
            $data[$k]['edit'] = Auth::guard('admin')->user()->can('修改角色');
        }

        return [
            'code'=> 0,
            'msg' => '',
            'count' => $count,
            'data' => $data
        ];
    }

    public function create(Permission $permission)
    {
        $permissions = $permission->get();
        return view('admin.roles.create',['permissions' => $permissions]);
    }

    public function store(Role $role,RolesRequest $request)
    {
        $role->name = $request->name;
        if ($role->save()) {
            // 给予权限
            $role->givePermissionTo($request->post('permissions'));
            return ['status' => 200,'msg' => '添加成功'];
        } else {
            return ['status' => 402,'msg' => '添加失败'];
        }
    }

    public function edit(Role $role,Permission $permission)
    {
        $rolesHasPermissions = $role->permissions->pluck('name')->toArray();

        $permissions = $permission->get();
        return view('admin.roles.edit',[
            'role' => $role,
            'rolesHasPermissions' => $rolesHasPermissions,
            'permissions' => $permissions
            ]);
    }

    public function update(Role $role,RolesRequest $request)
    {
        $role->name = $request->name;

        if ($role->save()) {
            $role->syncPermissions($request->permissions);
            return ['status' => 200,'msg' => '修改成功'];
        } else {
            return ['status' => 402,'msg' => '修改失败'];
        }
    }

    public function destroy(Role $role)
    {
        if ($role->delete()) {
            return ['status' => 200,'msg' => '删除成功'];
        } else {
            return ['status' => 422,'msg' => '删除失败'];
        }
    }
}
