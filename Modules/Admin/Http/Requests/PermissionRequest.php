<?php

namespace Modules\Admin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Modules\Admin\Entities\Permission;

class PermissionRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'role_id' => 'required|exists:Modules\Admin\Entities\Role,id',
            'page_id' => 'required|unique:Modules\Admin\Entities\PageRole,page_id,NULL,id,role_id,'.$this->get('role_id'),
            'can' => 'required',
            'can.*' => ['required', Rule::in(Permission::$choices)]
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
}
