<?php

namespace App\Http\Requests;

class PermissionsRequest extends Request
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
                     'unique:permissions',
                 ]
               ];
               break;

           case 'PUT':
               return [
                 'name' => [
                   'required',
                   'unique:permissions,name,'.$this->input('id').',id',
                 ],
               ];
               break;
       }
    }
}
