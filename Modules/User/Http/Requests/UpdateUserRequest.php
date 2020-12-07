<?php

namespace Modules\User\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'firstname' => 'string',
            'lastname' => 'string',
            'email' => 'email|unique:pgsql.admin.accounts,email,'.$this->user->id,
            'password' => [
                'min:6',
                'regex:/^.*(?=.{6,})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!@#$%^&*()_{}:;?~]).*$/',
                'confirmed'],
            'employee_type' => 'exists:Modules\User\Entities\EmployeeType,id',
            'company_id' => 'exists:Modules\Admin\Entities\Company,Id',
            'roles' => 'exists:Modules\Admin\Entities\Role,id',
            'permissions' => 'exists:Modules\Admin\Entities\Permission,id',
            'role_name' => 'required_with:permissions',
            'status' => 'integer|in:0,1,2,3,4'
        ];
    }

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
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'password.regex' => lang('password_requirement')
        ];
    }
}
