<?php

namespace App\Http\Requests\DeepPermission;

use Illuminate\Foundation\Http\FormRequest;

class CreateRole extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        switch($this->method())
        {
            case 'POST':
                return array(
                    'name' => 'required|unique:roles,name',
                    'code' => 'required|unique:roles,code',
                );
                
            case 'PUT':
                return array(
                    'name' => 'required|unique:roles,name,'.$this->role,
                    'code' => 'required|unique:roles,code,'.$this->role,
                );
            default: return array();
        }
    }
}
