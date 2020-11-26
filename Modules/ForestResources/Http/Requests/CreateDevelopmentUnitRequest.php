<?php

namespace Modules\ForestResources\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateDevelopmentUnitRequest extends FormRequest
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
            'Concession' => 'required|integer',
            'ProductType' => 'required|integer|exists:Modules\ForestResources\Entities\ProductType,Id',
            'Start' => 'required|date_format:Y-m-d',
            'End' => 'required|date_format:Y-m-d',
            'Geometry' => 'string',
            'Approved'=>'bool',
        ];
    }

}
