<?php

namespace Modules\ForestResources\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDevelopmentUnitRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'Number' => 'string',
            'Name' => 'string',
            'Concession' => 'integer',
            'ProductType' => 'integer|exists:Modules\ForestResources\Entities\ProductType,Id',
            'Start' => 'date_format:Y-m-d',
            'End' => 'date_format:Y-m-d',
            'Geometry' => 'string',
            'Approved'=>'bool',
        ];
    }

}
