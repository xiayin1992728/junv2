<?php

namespace App\Http\Controllers\AdminControllers;

use App\Models\Admin;
use App\Models\CountPeople;
use App\Models\Spread;
use App\Models\User;
use Illuminate\Http\Request;
use Auth;
use App\Http\Controllers\Controller;

class CountPeoplesController extends Controller
{
    public function index(Spread $spread,Admin $admin,CountPeople $countPeople,User $user)
    {
        return view('admin.countPeoples.index');
    }

    public function data(CountPeople $countPeople,Request $request,Admin $admin,User $user)
    {
        $admins = $admin->role('推广员')->get()->pluck('id')->toArray();
        $currentUser = Auth::guard('admin')->user();
        $time = date('Y-m-d',time());
        $registerNumber = 0;
        $verifyNumber = 0;
        $data = [];
        $offset = ($request->get('page')-1)*$request->get('limit');
        // 是推广员只能看到通过自己推广注册的
        if (in_array($currentUser->id,$admins)) {
            $registerNumber = ($registerNumber = $countPeople->where('uid',$currentUser->id)->where('create_time',$time)->first()) ? $registerNumber->people : 0;
            $verifyNumber = ($verifyNumber = $countPeople->where('uid',$currentUser->id)->where('create_time',$time)->first()) ? $verifyNumber->verify : 0;
            $spreads = $currentUser->spread->pluck('id')->toArray();
            $limit = ($request->get('limit') > floor($registerNumber)) ? floor($registerNumber) : $request->get('limit');
            $data = $user->whereIn('id',$spreads)->offset($offset)->limit($limit)->orderByDesc('id')->get()->toArray();
            $data = $this->filterData($data);
        } else {
            $registerNumber = $countPeople->where('create_time',$time)->sum('people');
            $verifyNumber = $countPeople->where('create_time',$time)->sum('verify');
            $data = $user->where('sid','<>',0)->offset($offset)->limit($request->limit)->orderByDesc('id')->get()->toArray();
        }
        return [
            'code'=> 0,
            'msg' => '',
            'count' => floor($registerNumber),
            'data' => $data,
            'registerNumber' => floor($registerNumber),
            'verifyNumber' => floor($verifyNumber),
        ];
    }


    public function search(CountPeople $countPeople,Request $request,Admin $admin,User $user)
    {
        $admins = $admin->role('推广员')->get()->pluck('id')->toArray();
        $currentUser = Auth::guard('admin')->user();
        $time = date('Y-m-d',time());
        $registerNumber = 0;
        $verifyNumber = 0;
        $data = [];
        $offset = ($request->get('page')-1)*$request->get('limit');
        $count = 0;
        $where = $this->filterItem($request);
        $countWhere = [
            ['create_time','>',$request->start],
            ['create_time','<',$request->end],
        ];

        // 是推广员只能看到通过自己推广注册的
        if (in_array($currentUser->id,$admins)) {
            $registerNumber = ($registerNumber = $countPeople->where('uid',$currentUser->id)->where($countWhere)->first()) ? $registerNumber->people : 0;
            $verifyNumber = ($verifyNumber = $countPeople->where('uid',$currentUser->id)->where($countWhere)->first()) ? $verifyNumber->verify : 0 ;
            $spreads = $currentUser->spread->pluck('id')->toArray();
            $data = $user->whereIn('id',$spreads)->where($where)->offset($offset)->limit($request->get('limit'))->orderByDesc('id')->get()->toArray();
            $data = $this->filterData($data);
            $count = $user->whereIn('id',$spreads)->where($where)->count('id');
        }  else {
            $registerNumber = $countPeople->where($countWhere)->where('create_time',$time)->sum('people');
            $verifyNumber = $countPeople->where($countWhere)->where('create_time',$time)->sum('verify');
            $data = $user->where($where)->offset($offset)->limit($request->limit)->orderByDesc('id')->get()->toArray();
        }

        return [
            'code'=> 0,
            'msg' => '',
            'count' => $count,
            'data' => $data,
            'registerNumber' => floor($registerNumber),
            'verifyNumber' => floor($verifyNumber),
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

        return $where;
    }

    protected function filterData($data)
    {
        foreach ($data as $k => $v) {
            $data[$k]['name'] = $v['name'] ? mb_substr($v['name'],0,1,'UTF-8').str_repeat('*',mb_strlen($v['name'],'UTF-8')-1) : '';
            $data[$k]['phone'] = substr_replace($v['phone'],'****',3,4);
        }
        return $data;
    }
}
