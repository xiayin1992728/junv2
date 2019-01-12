<?php

namespace App\Http\Requests;

class SpreadRequest extends Request
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
                    'change' => [

                    ],
                    'uid' => 'required',
                    'pid' => 'required',
                    'pages' => 'required',
                ];
                break;
            case 'PUT':
                return [
                    'change' => [

                    ],
                    'uid' => 'required',
                    'pid' => 'required',
                    'pages' => 'required'
                ];
                break;
        }
    }

    public function attributes()
    {
        return [
          'uid' => '推广员',
          'pid' => '产品',
          'change' => '流量控制',
        ];
    }
}
