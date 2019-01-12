<?php

namespace App\Http\Requests;


class ChannelRequest extends Request
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
                    'name' => [
                      'required',
                      'unique:channels'
                    ],
                    'company' => [
                        'required',
                        'unique:channels'
                    ],
                    'types' => 'required',
                    'uid' => 'required',
                ];
                break;
            case 'PUT':
                return [
                    'name' => [
                        'required',
                        'unique:channels,name,'.$this->input('id').',id'
                    ],
                    'company' => [
                        'required',
                        'unique:channels,company,'.$this->input('id').',id'
                    ],
                    'types' => 'required',
                    'uid' => 'required',
                ];
                break;
        }
    }

    public function attributes()
    {
        return [
          'uid' => '推广者',
          'company' => '公司名称',
          'name' => '渠道名称',
          'types' => '结算方式',
        ];
    }
}
