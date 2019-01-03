<?php

namespace App\Http\Requests;

class LoanRequest extends Request
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'money' => 'required|numeric',
            'days' => 'required|numeric'
        ];
    }

    public function messages()
    {
        return [
          'money.required' => '选择金额',
          'money.numeric' => '金额格式错误',
          'days.required' => '选择时间',
          'days.numeric' =>'时间格式错误',
        ];
    }
}
