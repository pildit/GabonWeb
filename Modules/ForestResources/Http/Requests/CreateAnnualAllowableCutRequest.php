<?php

namespace Modules\ForestResources\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateAnnualAllowableCutRequest extends FormRequest
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
            'Name' => 'required|string',
            'Geometry' => 'required',
        ];
    }

}
