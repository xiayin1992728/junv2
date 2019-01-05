<?php

namespace App\Http\Controllers\AdminControllers;

use Auth;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UsersController extends Controller
{
    public function index()
    {
        return view('admin.users.index');
    }

    public function data(User $user,Request $request)
    {
        $offset = ($request->get('page')-1)*$request->get('limit');
        $count = $user->count('id');
        $data = $user->offset($offset)->limit($request->get('limit'))->get();
        foreach ($data as $k => $v) {
            $data[$k]['del'] = Auth::guard('admin')->user()->can('删除用户');
            $data[$k]['edit'] = Auth::guard('admin')->user()->can('修改用户');
        }

        return [
            'code'=> 0,
            'msg' => '',
            'count' => $count,
            'data' => $data
        ];
    }

    public function create(Admin $admin)
    {
        $admins = $admin->roles;
        return view('admin.users.create');
    }

    public function store(User $user,Request $request)
    {
        $user->phone = $request->phone;
        $user->password = bcrypt($request->password);
        $user->name = $request->name;

        if ($user->save()) {
            return ['status' => 200,'msg' => '添加成功'];
        } else {
            return ['status' => 402,'msg' => '添加失败'];
        }
    }

    public function edit(User $user)
    {

        return view('admin.users.edit',[
            'user' => $user,
        ]);
    }

    public function update(User $user,Request $request)
    {
        $user->name = $request->name;
        $user->phone = $request->phone;

        if ($user->save()) {
            return ['status' => 200,'msg' => '修改成功'];
        } else {
            return ['status' => 402,'msg' => '修改失败'];
        }
    }

    public function destroy(User $user)
    {
        if ($user->delete()) {
            return ['status' => 200,'msg' => '删除成功'];
        } else {
            return ['status' => 422,'msg' => '删除失败'];
        }
    }

    public function search(User $user,Request $request)
    {
        $offset = ($request->get('page')-1)*$request->get('limit');
        $count = $user->count('id');
        $where = $this->filterItem($request);
        $data = $user->where($where)->offset($offset)->limit($request->get('limit'))->get();
        foreach ($data as $k => $v) {
            $data[$k]['del'] = Auth::guard('admin')->user()->can('删除用户');
            $data[$k]['edit'] = Auth::guard('admin')->user()->can('修改用户');
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
