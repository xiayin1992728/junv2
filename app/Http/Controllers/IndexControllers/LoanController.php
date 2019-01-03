<?php

namespace App\Http\Controllers\IndexControllers;

use Auth;
use App\Models\Money;
use App\Http\Requests\LoanRequest;
use App\Http\Controllers\Controller;

class LoanController extends Controller
{
    /**
     * 借款金额存入
     * @param Money $money
     * @param LoanRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Money $money,LoanRequest $request)
    {
        $money->days = $request->days;
        $money->money = $request->money;
        $money->uid = Auth::id();

        $money->save();

        return redirect()->route('verify.index');
    }
}
