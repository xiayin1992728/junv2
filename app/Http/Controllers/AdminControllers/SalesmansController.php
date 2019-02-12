<?php

namespace App\Http\Controllers\AdminControllers;

use Illuminate\Http\Request;
use App\Models\CountPeople;
use App\Models\Admin;
use App\Models\User;
use App\Http\Controllers\Controller;

class SalesmansController extends Controller
{
    public function index($id)
    {
        return view('admin.salesmans.index',['id' => $id]);
    }

    public function data(CountPeople $countPeople, Request $request, Admin $admin, User $user,$id)
    {
        $salesman = $admin->find($id);
        $offset = ($request->get('page')-1)*$request->get('limit');
        $registerNumber = ($registerNumber = $countPeople->where('uid', $id)->first()) ? $registerNumber->people : 0;
        $verifyNumber = ($verifyNumber = $countPeople->where('uid',$id)->first()) ? $verifyNumber->verify : 0;
        $spreads = $salesman->spread->pluck('id')->toArray();
        $limit = ($request->get('limit') > floor($registerNumber)) ? floor($registerNumber) : $request->get('limit');
        $data = $user->whereIn('id', $spreads)->offset($offset)->limit($limit)->orderByDesc('id')->get()->toArray();

        return [
            'code' => 0,
            'msg' => '',
            'count' => floor($registerNumber),
            'data' => $data,
            'registerNumber' => floor($registerNumber),
            'verifyNumber' => floor($verifyNumber),
        ];
    }

    public function search(CountPeople $countPeople,Request $request,Admin $admin,User $user,$id)
    {
        $currentUser = $admin->find($id);
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

        $registerNumber = ($registerNumber = $countPeople->where('uid',$id)->where($countWhere)->first()) ? $registerNumber->people : 0;
        $verifyNumber = ($verifyNumber = $countPeople->where('uid',$id)->where($countWhere)->first()) ? $verifyNumber->verify : 0 ;
        $spreads = $currentUser->spread->pluck('id')->toArray();
        $data = $user->whereIn('id',$spreads)->where($where)->offset($offset)->limit($request->get('limit'))->orderByDesc('id')->get()->toArray();
        $count = $user->whereIn('id',$spreads)->where($where)->count('id');


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
}
