<?php

namespace Modules\ForestResources\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateManagementUnitRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'Number' => 'required|string',
            'Name' => 'required|string',
            'ProductType' => 'required|integer|exists:Modules\ForestResources\Entities\ProductType,Id',
            'DevelopmentUnit' => 'required|exists:Modules\ForestResources\Entities\DevelopmentUnit,Id',
            'Geometry' => 'string',
            'Approved' => 'bool',
        ];
    }

}
