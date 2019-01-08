<?php

namespace App\Http\Requests;


class ProductRequest extends Request
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
                    'unique:products'
                  ],
                  'logo' => 'required',
                  'maxs' => 'required',
                  'tag' => 'required',
                  'longtimes' => 'required',
                  'link' => 'required',
                  'saleman' => 'required',
                  'types' => 'required',
                ];
                break;
            case 'PUT':
                return [
                    'name' => [
                        'required',
                        'unique:products,name,'.$this->input('id').',id',
                    ],
                    'logo' => 'required',
                    'maxs' => 'required',
                    'tag' => 'required',
                    'longtimes' => 'required',
                    'link' => 'required',
                    'saleman' => 'required',
                    'types' => 'required',
                ];
            break;
        }
    }

    public function messages()
    {
        return [
            'name.required' => '产品名称不能为空',
            'name.unique' => '产品名称已存在',
            'logo.required' => '请上传 logo',
            'maxs.required' => '最大额度不能为空',
            'tag.required' => '简介不能为空',
            'link.required' => '产品链接不能为空',
            'saleman.required' => '业务员不能为空',
            'longtimes.required' => '借款期限不能为空',
            'types.required' => '选择产品类型',
        ];
    }
}
