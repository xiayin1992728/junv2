<?php

namespace App\Http\Controllers\AdminControllers;

use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin;

class SessionsController extends Controller
{
    public function login()
    {
        return view('admin.sessions.login');
    }

    public function store(Admin $admin,Request $request)
    {
        $this->validate($request,
            [
           'phone' => [
              'required',
               'regex:/^1[34578]\d{9}$/'
           ] ,
            'password' => 'required'
        ],
         [
            'phone.required' => '手机号不能为空',
            'phone.regex' => '手机号码格式错误',
            'password.required' => '密码不能为空',
        ]);

        $credentials = [
            'phone' => $request->post('phone'),
            'password' => $request->post('password')
        ];

        if (Auth::guard('admin')->attempt($credentials)) {
            return ['status' => 200,'msg' => '登录成功'];
        } else {
            return ['status' => 400,'msg' => '用户不存在或密码错误'];
        }
    }
}
