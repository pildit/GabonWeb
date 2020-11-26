<?php

namespace Modules\ForestResources\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAnnualAllowableCutRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'ManagementUnit' => 'exists:Modules\ForestResources\Entities\ManagementUnit,Id',
            'ManagementPlan' => 'exists:Modules\ForestResources\Entities\ManagementPlan,Id',
            'Name' => 'string',
            'Geometry' => 'string',
            'AacId' => 'string',
            "ProductType" => 'nullable|exists:Modules\ForestResources\Entities\ProductType,Id'
        ];
    }

}
