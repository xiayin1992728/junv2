<?php

namespace App\Http\Requests;


class RolesRequest extends Request
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
                        'unique:roles',
                    ],
                    'permissions' => 'required',
                ];
                break;

            case 'PUT':
                return [
                    'name' => [
                        'required',
                        'unique:roles,name,'.$this->input('id').',id',
                    ],
                    'permissions' => 'required',
                ];
                break;
        }
    }

    public function attributes()
    {
        return [
            'name' => '角色名称',
            'permissions' => '拥有权限',
        ];
    }
}
