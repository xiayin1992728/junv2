<?php

namespace App\Http\Requests;

class UserRequest extends Request
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
                        'unique:users'
                    ],
                    'sid' => 'required',
                ];
                break;
            case 'PUT':
                return [
                    'phone' => [
                        'required',
                        'regex:/^((13[0-9])|(14[5,7,9])|(15[^4])|(18[0-9])|(17[0,1,3,5,6,7,8]))\d{8}$/',
                        'unique:users,phone,'.$this->input('id').',id',
                    ],
                    'sid' => 'required'
                ];
                break;
        }
    }

    public function attributes()
    {
        return [
          'phone' =>'手机号',
          'sid' => '关联推广者'
        ];
    }
}
