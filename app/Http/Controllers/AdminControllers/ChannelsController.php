<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Requests\ChannelRequest;
use App\Models\Admin;
use Auth;
use App\Models\Channel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ChannelsController extends Controller
{
    public function index()
    {
        return view('admin.channels.index');
    }

    public function data(Channel $channel,Request $request)
    {
        $offset = ($request->get('page')-1)*$request->get('limit');
        $count = $channel->count('id');
        $data = $channel->offset($offset)->limit($request->get('limit'))->orderByDesc('id')->get();
        foreach ($data as $k => $v) {
            $data[$k]['adminChannel'] = $v->admin->name;
            $data[$k]['del'] = Auth::guard('admin')->user()->can('删除渠道');
            $data[$k]['edit'] = Auth::guard('admin')->user()->can('修改渠道');
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
        $admins = $admin::role('推广员')->get();
        return view('admin.channels.create',['admins' => $admins]);
    }

    public function store(Channel $channel,ChannelRequest $request)
    {
        $channel->name = $request->name;
        $channel->uid = $request->uid;
        $channel->types = $request->types;
        $channel->company = $request->company;

        if ($channel->save()) {
            return ['status' => 200,'msg' => '添加成功'];
        } else {
            return ['status' => 402,'msg' => '添加失败'];
        }
    }

    public function edit(Channel $channel,Admin $admin)
    {
        $admins = $admin::role('推广员')->get();
        $types = ['微信支付','支付宝支付','其他'];
        //dd($admins);
        return view('admin.channels.edit',[
            'admins' => $admins,
            'types' => $types,
            'channel' => $channel
        ]);
    }

    public function update(Channel $channel,ChannelRequest $request)
    {
        $channel->name = $request->name;
        $channel->uid = $request->uid;
        $channel->types = $request->types;
        $channel->company = $request->company;


        if ($channel->save()) {
            return ['status' => 200,'msg' => '修改成功'];
        } else {
            return ['status' => 402,'msg' => '修改失败'];
        }
    }

    public function destroy(Channel $channel)
    {
        if ($channel->delete()) {
            return ['status' => 200,'msg' => '删除成功'];
        } else {
            return ['status' => 422,'msg' => '删除失败'];
        }
    }

    public function search(Channel $channel,Request $request)
    {
        $offset = ($request->get('page')-1)*$request->get('limit');
        $where = $this->filterItem($request);
        $data = $channel->where($where)->offset($offset)->limit($request->get('limit'))->get();
        $count = $channel->where($where)->count('id');
        foreach ($data as $k => $v) {
            $data[$k]['del'] = Auth::guard('admin')->user()->can('删除渠道');
            $data[$k]['edit'] = Auth::guard('admin')->user()->can('修改渠道');
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
}
