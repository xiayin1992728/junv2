<?php

namespace App\Http\Requests;

class ProductPageRequest extends Request
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
                    'pid' => 'required',
                    'name' => [
                      'required',
                      'unique:product_pages',
                    ],
                    'pages' => 'required',
                ];
                break;
            case 'PUT':
                return [
                    'pid' => 'required',
                    'name' => [
                        'required',
                        'unique:product_pages,name,'.$this->input('id').',id',
                    ],
                    'pages' => 'required',
                ];
                break;
        }
    }

    public function attributes()
    {
        return [
          'pid' => '所属产品',
          'name' => '页面名称',
          'pages' => '页面链接',
        ];
    }
}
