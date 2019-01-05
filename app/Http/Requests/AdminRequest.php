<?php

namespace App\Http\Requests;


class AdminRequest extends Request
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        switch ($this->method()) {
            case 'POST':
                return [
                    'phone' => [
                        'required',
                        'regex:/^((13[0-9])|(14[5,7,9])|(15[^4])|(18[0-9])|(17[0,1,3,5,6,7,8]))\d{8}$/',
                        'unique:admins'
                    ],
                    'name' => 'required',
                    'password' => [
                        'required',
                        'max:20',
                        'min:6'
                    ],
                    'roles' => 'required'
                ];
                break;
            case 'PUT':
                return [
                    'phone' => [
                        'required',
                        'regex:/^((13[0-9])|(14[5,7,9])|(15[^4])|(18[0-9])|(17[0,1,3,5,6,7,8]))\d{8}$/',
                        'unique:admins,phone,'.$this->input('id').',id',
                    ],
                    'name' => 'required',
                    'password' => [
                        'nullable',
                        'max:20',
                        'min:6'
                    ],
                    'roles' => 'required'
                ];
                break;
        }
    }

    public function attributes()
    {
        return [
            'phone' => '手机号',
            'password' => '密码',
            'name' => '用户名',
            'roles' => '角色'
        ];
    }
}
