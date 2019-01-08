<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Requests\UserRequest;
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
            $data[$k]['sname'] = $v->admin['name'];
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
        $admins = $admin->role('推广员')->get();

        return view('admin.users.create',compact('admins'));
    }

    public function store(User $user,UserRequest $request)
    {
        $user->phone = $request->phone;
        $user->password = bcrypt($request->phone);
        $user->name = $request->name;
        $user->idcard = $request->idcard;
        $user->credit = $request->credit;
        $user->qq = $request->qq;
        $user->weixin = $request->weixin;
        $user->work = $request->work;
        $user->house = $request->house;
        $user->card = $request->card;
        $user->accumulation = $request->accumulation;
        $user->insurance = $request->insurance;
        $user->sid = $request->sid;

        if ($user->save()) {
            return ['status' => 200,'msg' => '添加成功'];
        } else {
            return ['status' => 402,'msg' => '添加失败'];
        }
    }

    public function edit(User $user,Admin $admin)
    {
        $admins = $admin->role('推广员')->get();

        return view('admin.users.edit',[
            'user' => $user,
            'admins' => $admins
        ]);
    }

    public function update(User $user,Request $request)
    {
        $user->phone = $request->phone;
        $user->password = bcrypt($request->phone);
        $user->name = $request->name;
        $user->idcard = $request->idcard;
        $user->credit = $request->credit;
        $user->qq = $request->qq;
        $user->weixin = $request->weixin;
        $user->work = $request->work;
        $user->house = $request->house;
        $user->card = $request->card;
        $user->accumulation = $request->accumulation;
        $user->insurance = $request->insurance;
        $user->sid = $request->sid;

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
}
