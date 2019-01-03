<?php

namespace App\Http\Controllers\IndexControllers;

use Auth;
use App\Models\User;
use App\Http\Requests\VerifyRequest;
use App\Http\Controllers\Controller;

class VerifyController extends Controller
{
    public function store(VerifyRequest $request)
    {
        $user = User::where('id',Auth::id())->first();
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

        $user->save();
        return redirect()->route('feature.index');
    }
}
