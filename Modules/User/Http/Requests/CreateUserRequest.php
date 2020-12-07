<?php

namespace Modules\User\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'firstname' => 'required|string',
            'lastname' => 'required|string',
            'email' => 'required|email|unique:pgsql.admin.accounts',
            'password' => ['required',
                'min:6',
                'regex:/^.*(?=.{6,})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!@#$%^&*()_{}:;?~]).*$/',
                'confirmed'],
            'employee_type' => 'exists:Modules\User\Entities\EmployeeType,id',
            'company_id' => 'exists:Modules\Admin\Entities\Company,Id'
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
