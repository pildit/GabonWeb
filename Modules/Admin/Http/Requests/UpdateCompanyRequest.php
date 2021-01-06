<?php

namespace Modules\Admin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCompanyRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'string|unique:Modules\Admin\Entities\Company,Name,'.$this->company->Id.',Id',
            'types' => 'array',
            'types.*' => 'exists:Modules\Admin\Entities\CompanyType,Id',
            'group-name' => 'string',
            'trade-register' => 'string'
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
