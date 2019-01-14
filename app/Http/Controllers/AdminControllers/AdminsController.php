<?php

namespace App\Http\Controllers\AdminControllers;

use App\Models\User;
use Auth;
use Spatie\Permission\Models\Role;
use App\Models\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\AdminRequest;

class AdminsController extends Controller
{
    public function index()
    {
        $roles = Role::get();

        return view('admin.admins.index',['roles' => $roles]);
    }

    public function data(Admin $admin,Request $request)
    {
        $offset = ($request->get('page')-1)*$request->get('limit');
        $count = $admin->count('id');
        $data = $admin->offset($offset)->limit($request->get('limit'))->get();
        foreach ($data as $k => $v) {
             $data[$k]['role'] = $v->getRoleNames();
             $data[$k]['own'] = ($v->id == Auth::id());
             $data[$k]['del'] = Auth::user()->can('删除用户');
             $data[$k]['edit'] = Auth::user()->can('修改用户');
        }

        return [
            'code'=> 0,
            'msg' => '',
            'count' => $count,
            'data' => $data
        ];
    }

    public function create(Role $roles)
    {
        $roles = $roles->all();
        return view('admin.admins.create',['roles' => $roles]);
    }

    public function store(Admin $admin,AdminRequest $request)
    {
        $admin->phone = $request->phone;
        $admin->password = bcrypt($request->password);
        $admin->name = $request->name;
        $admin->alias = $request->alias;
        $admin->company = $request->company;
        $admin->types = $request->types;

        if ($admin->save()) {
            $admin->assignRole($request->roles);
            return ['status' => 200,'msg' => '添加成功'];
        } else {
            return ['status' => 402,'msg' => '添加失败'];
        }
    }

    public function edit(Admin $admin,Role $roles)
    {
        $roles = $roles->all();
        return view('admin.admins.edit',[
            'admin' => $admin,
            'roles' => $roles,
        ]);
    }

    public function update(Admin $admin,Role $roles,AdminRequest $request)
    {
        $admin->name = $request->name;
        $admin->phone = $request->phone;
        if ($request->pasword) {
            $admin->password = bcrypt($request->password);
        }

        if ($admin->save()) {
            $admin->syncRoles($request->roles);
            return ['status' => 200,'msg' => '修改成功'];
        } else {
            return ['status' => 402,'msg' => '修改失败'];
        }
    }

    public function destroy(Admin $admin)
    {
        if ($admin->delete()) {
            return ['status' => 200,'msg' => '删除成功'];
        } else {
            return ['status' => 422,'msg' => '删除失败'];
        }
    }

    public function search(Admin $admin,Request $request)
    {
        $offset = ($request->get('page')-1)*$request->get('limit');
        $where = $this->filterItem($request);
        if ($request->roles) {
            $data = $admin->role($request->roles)->where($where)->offset($offset)->limit($request->get('limit'))->get();
            $count = $admin->role($request->roles)->where($where)->count('id');
        } else {
            $data = $admin->where($where)->offset($offset)->limit($request->get('limit'))->get();
            $count = $admin->where($where)->count('id');
        }
        foreach ($data as $k => $v) {
            $data[$k]['role'] = $v->getRoleNames();
            $data[$k]['own'] = ($v->id == Auth::id());
            $data[$k]['del'] = Auth::user()->can('删除用户');
            $data[$k]['edit'] = Auth::user()->can('修改用户');
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
            'phone' => ['phone','like',$request->phone.'%'],
        ];
        foreach ($item as $k => $v) {
            if ($request->$k) {
                $where[] = $v;
            }
        }
        return $where;
    }
}
