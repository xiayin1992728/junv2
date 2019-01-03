<?php

namespace App\Http\Requests;


class LoginRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'phone' => [
                'required',
                'regex:/^((13[0-9])|(14[5,7,9])|(15[^4])|(18[0-9])|(17[0,1,3,5,6,7,8]))\d{8}$/'
            ],
            'captcha' => 'required',
            'code' => 'required|numeric',
        ];
    }

    public function messages()
    {
        return [
            'phone.required' => '手机号不能为空',
            'phone.regex' => '手机格式错误',
            'captcha.required' => '验证码不能为空',
            'captcha.captcha' => '图形验证码错误',
            'code.required' => '短信验证码不能为空',
            'code.captcha' => '短信验证码输入数字'
        ];
    }
}
