<?php

namespace App\Http\Controllers\IndexControllers;

use App\Models\CountPeople;
use App\Models\Spread;
use Auth;
use App\Models\User;
use App\Http\Requests\VerifyRequest;
use App\Http\Controllers\Controller;

class VerifyController extends Controller
{
    public function store(VerifyRequest $request,CountPeople $countPeople)
    {
        $user = User::where('id',Auth::guard('web')->id())->first();
        $user->name = $request->name;
        $user->idcard = $request->idcard;
        $user->credit = $request->credit;
        $user->qq = $request->qq;
        $user->weixin = $request->weixin;

        $user->work = $request->work ?? 0;
        $user->house = $request->house ?? 0;
        $user->card = $request->card ?? 0;
        $user->accumulation = $request->accumulation ?? 0;
        $user->insurance = $request->insurance ?? 0;

        if ($user->save()) {
            // 更新后台实名认证数量
            if ($user->sid) {
                $time = date('Y-m-d',time());
                if ($countPeople = $countPeople->where('create_time',$time)->first()) {
                    $countPeople->verify = $countPeople->verify + $user->change;
                } else {
                    $spread = Spread::where('id',$user->sid)->first();
                    $countPeople->verify = $user->change;
                    $countPeople->sid = $user->sid;
                    $countPeople->uid = $spread->admin->id;
                }
            }
            $countPeople->save();
        }

        return redirect()->route('feature.index');
    }
}
